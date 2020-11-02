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
            $data = \DB::table('hosts')->get();

            foreach ($data as $data ) {
            if(checkOnline($data->ip)) {
            \DB::table('status')->insert(
                ['host' => $data->name, 'up_down' => 'online']
            );
            }
            else {
                \DB::table('status')->insert(
                    ['host' => $data->name, 'up_down' => 'offline']
                );
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
