<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Posts embeds to a Discord webhook.
 *
 * The webhook URL is validated before use so a bad or tampered .env value can
 * never make the application post incident data to an arbitrary host, and the
 * URL itself (which is a secret) is never written to the log.
 */
class DiscordWebhook
{
    public const USERNAME = 'Fjellserver.no | Driftsmeldinger';

    private const ALLOWED_PREFIXES = [
        'https://discord.com/api/webhooks/',
        'https://discordapp.com/api/webhooks/',
    ];

    public static function isValidUrl(mixed $url): bool
    {
        if (! is_string($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        foreach (self::ALLOWED_PREFIXES as $prefix) {
            if (str_starts_with($url, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Post a single embed. Returns true when Discord accepted it.
     *
     * @param  array<string, mixed>  $embed
     */
    public function send(mixed $url, array $embed): bool
    {
        if (! self::isValidUrl($url)) {
            Log::error('Discord webhook URL is missing or is not a discord.com webhook; message not sent.');

            return false;
        }

        try {
            $response = Http::timeout(10)->asJson()->post($url, [
                'username' => self::USERNAME,
                'tts' => false,
                'embeds' => [$embed],
            ]);
        } catch (ConnectionException $e) {
            Log::error('Discord webhook request failed: '.$e->getMessage());

            return false;
        }

        if (! $response->successful()) {
            Log::error('Discord webhook rejected the message.', ['status' => $response->status()]);

            return false;
        }

        return true;
    }
}
