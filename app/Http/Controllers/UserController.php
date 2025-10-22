<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function formSubmit(Request $request) 
    {
        // 1. VALIDATION AND DATABASE INSERT (Runs first)
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'signatur' => 'required',
        ]);

        \DB::table('info')->insert(
            ['name' => $request->name, 'description' => $request->description, 'category' => $request->category, 'signatur' => $request->signatur]
        );

        // 2. RETRIEVE AND VALIDATE WEBHOOK URL
        $url = config('discord.DISCORD_WEBHOOK');

        // Log the value that was loaded (security-conscious logging)
        if (is_string($url) && strlen($url) > 20) {
            Log::info('Discord Webhook config loaded. URL starts with: ' . substr($url, 0, 30) . '...');
        } else {
            Log::warning('Discord Webhook config is missing or invalid type.');
        }

        // Check if the URL is valid and looks like a Discord Webhook
        $is_valid_url = filter_var($url, FILTER_VALIDATE_URL);
        $is_discord_webhook = is_string($url) && str_starts_with($url, 'https://discord.com/api/webhooks/');

        if (!$is_valid_url || !$is_discord_webhook) {
            Log::error("Invalid Discord Webhook URL format. Check .env (DISCORD_WEBHOOK).");
            Log::debug("Attempted Webhook URL: " . (is_string($url) ? $url : 'null/not a string'));
            return redirect()->back(); 
        }

        // 3. PREPARE DISCORD MESSAGE
        $category = "❓";
        $coolor = "808080"; 

        switch ($request->category) {
            case "good":
                $category = "✅";
                $coolor = "00FF00"; 
                break;
            case "bad":
                $category = "❌";
                $coolor = "FF0000"; 
                break;
            case "warning":
                $category = "⚠️";
                $coolor = "FFFF00"; 
                break;
            case "fix":
                $category = "🛠️";
                $coolor = "808080"; 
                break;
        }

        $current_date_time = Carbon::now()->toDateTimeString();

        $hookObject = json_encode([
            "username" => "Fjellserver.no | Driftsmeldinger",
            "tts" => false,
            "embeds" => [
                [
                    "title" => "$category $request->name",
                    "type" => "rich",
                    "description" => "$request->description\n\n$request->signatur",
                    "timestamp" => $current_date_time,
                    "color" => hexdec( $coolor ), 
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        // 4. EXECUTE C-URL REQUEST
        $ch = curl_init();

        curl_setopt_array( $ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hookObject,
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        // 5. CHECK C-URL RESPONSE AND LOG ERRORS
        $response = curl_exec($ch);

        // **CRITICAL STEP:** Check for a complete cURL failure (Status: 0)
        if ($response === false) {
            $curl_error = curl_error($ch);
            $curl_errno = curl_errno($ch);

            Log::error("Discord Webhook cURL Execution Failed! Check server firewall or PHP cURL extension.");
            Log::error("cURL Error: [{$curl_errno}] {$curl_error}"); 

            curl_close($ch);
            return redirect()->back(); // Fail gracefully
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 204) {
            Log::error("Discord Webhook post failed!");
            Log::debug("Status: {$http_code}, Response: {$response}");
        }

        curl_close($ch);

        return redirect()->back();
    }
}