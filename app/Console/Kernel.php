<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $host = \DB::table('hosts')->get();

            foreach ($host as $host ) {
            if(checkOnline($host->ip)) {
                \DB::table('status')->updateOrInsert(
                    ['host' => $host->name],
                    ['up_down' => 'online', 'created_at' => now(), 'rank' => $host->rank],
                );
            }
            else {
                 \DB::table('status')->updateOrInsert(
                    ['host' => $host->name, 'rank' => $host->rank],
                    ['up_down' => 'offline', 'created_at' => now()],
                 );
                offline($host->name);
            }
        }
         })->everyMinute();
    
        function checkOnline($domain) {
            $curlInit = curl_init($domain);
            curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
            curl_setopt($curlInit,CURLOPT_HEADER,true);
            curl_setopt($curlInit,CURLOPT_NOBODY,true);
            curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
         
            //get answer
            $response = curl_exec($curlInit);
         
            curl_close($curlInit);
            if ($response) return true;
            return false;
         }

        function offline($n) {
            // Replace the URL with your own webhook url
            $url = $_ENV['DISCORD_WEBHOOK_DOWN_ALERT'];

           // $current_date_time = Carbon::now()->toDateTimeString();

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
                        "title" => "$n er nede for telling. ❌",

                        // The type of your embed, will ALWAYS be "rich"
                        "type" => "rich",

                        // A description for your embed
                        //"description" => "",

                        /* A timestamp to be displayed below the embed, IE for when an an article was posted
                        * This must be formatted as ISO8601
                        */
                        //"timestamp" => "$current_date_time",

                        // The integer color to be used on the left side of the embed
                        "color" => hexdec( "FF0000" ),
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
        }
    
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
