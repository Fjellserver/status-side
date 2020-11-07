<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function formSubmit(Request $request) 
    {
       // dd($request->all());
        \DB::table('info')->insert(
            ['navn' => $request->navn, 'beskrivelse' => $request->beskrivelse]
        );

// Replace the URL with your own webhook url
$url = "https://discordapp.com/api/webhooks/774603505171693608/TYhbJzLS3gAWdUlRpTBPbtvudes_yya1uu6Dww2A-O-tLXJhBftNJPCHUQ3laEykxr2c";

$current_date_time = Carbon::now()->toDateTimeString();
$hookObject = json_encode([
    /*
     * The username shown in the message
     */
    "username" => "Fjellserver.no | Driftsmeldinger",
    /*
     * Whether or not to read the message in Text-to-speech
     */
    "tts" => false,
    /*
     * File contents to send to upload a file
     */
    // "file" => "",
    /*
     * An array of Embeds
     */
    "embeds" => [
        /*
         * Our first embed
         */
        [
            // Set the title for your embed
            "title" => "$request->navn",

            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",

            // A description for your embed
            "description" => "$request->beskrivelse",

            /* A timestamp to be displayed below the embed, IE for when an an article was posted
             * This must be formatted as ISO8601
             */
            "timestamp" => "$current_date_time",

            // The integer color to be used on the left side of the embed
            "color" => hexdec( "00FF00" ),
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();

curl_setopt_array( $ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $hookObject,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);

$response = curl_exec( $ch );
curl_close( $ch );

return redirect()->to('/');

    }
}
