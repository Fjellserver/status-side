<?php

namespace App\Console\Commands;

use App\Services\DiscordWebhook;
use App\Services\HostProbe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckHosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probe every monitored host, record its status and alert Discord after repeated failures';

    public function handle(HostProbe $probe, DiscordWebhook $discord): int
    {
        foreach (DB::table('hosts')->get() as $host) {
            if ($probe->isOnline((string) $host->ip, (int) $host->port)) {
                DB::table('status')->updateOrInsert(
                    ['host' => $host->name],
                    ['up_down' => 'online', 'created_at' => now(), 'rank' => $host->rank, 'down_count' => '0'],
                );

                continue;
            }

            $failures = (int) DB::table('status')->where('host', $host->name)->value('down_count');

            DB::table('status')->updateOrInsert(
                ['host' => $host->name, 'rank' => $host->rank],
                ['up_down' => 'offline', 'created_at' => now(), 'down_count' => $failures + 1],
            );

            if ($failures > 2) {
                $discord->send(config('discord.DISCORD_WEBHOOK_DOWN_ALERT'), [
                    'title' => "{$host->name} er nede for telling. ❌",
                    'type' => 'rich',
                    'color' => hexdec('FF0000'),
                ]);
            }
        }

        return self::SUCCESS;
    }
}
