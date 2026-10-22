<?php

namespace App\Services;

/**
 * Checks whether a monitored host answers on a given port.
 *
 * The probe only speaks HTTP(S), never follows redirects and always times
 * out, so a misconfigured or hostile host entry cannot make the scheduler
 * hang or reach out over other protocols (file://, gopher://, ...).
 */
class HostProbe
{
    public function __construct(
        private readonly int $connectTimeout = 10,
        private readonly int $timeout = 15,
    ) {
    }

    public function isOnline(string $address, int $port): bool
    {
        $handle = curl_init($address);

        if ($handle === false) {
            return false;
        }

        curl_setopt_array($handle, [
            CURLOPT_PORT => $port,
            CURLOPT_NOBODY => true,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
        ]);

        $response = curl_exec($handle);

        return is_string($response) && $response !== '';
    }
}
