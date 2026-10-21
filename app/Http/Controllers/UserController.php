<?php

namespace App\Http\Controllers;

use App\Services\DiscordWebhook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Incident category => [icon, embed colour].
     */
    private const CATEGORIES = [
        'good' => ['✅', '00FF00'],
        'bad' => ['❌', 'FF0000'],
        'warning' => ['⚠️', 'FFFF00'],
        'fix' => ['🛠️', '808080'],
    ];

    public function formSubmit(Request $request, DiscordWebhook $discord): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4000'],
            'category' => ['required', Rule::in(array_keys(self::CATEGORIES))],
            'signatur' => ['required', 'string', 'max:1000'],
        ]);

        DB::table('info')->insert([
            'name' => $data['name'],
            'description' => $data['description'],
            'category' => $data['category'],
            'signatur' => $data['signatur'],
        ]);

        [$icon, $color] = self::CATEGORIES[$data['category']];

        $discord->send(config('discord.DISCORD_WEBHOOK'), [
            'title' => "{$icon} {$data['name']}",
            'type' => 'rich',
            'description' => "{$data['description']}\n\n{$data['signatur']}",
            'timestamp' => now()->toIso8601String(),
            'color' => hexdec($color),
        ]);

        return redirect()->back();
    }
}
