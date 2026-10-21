<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds baseline browser security headers to every response.
 */
class SecurityHeaders
{
    /**
     * Only fjellserver.no and its subdomains may embed these pages in a frame.
     * This blocks clickjacking of the authenticated dashboard.
     */
    private const FRAME_ANCESTORS = "frame-ancestors 'self' https://fjellserver.no https://*.fjellserver.no";

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = $response->headers;

        $defaults = [
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
            'Content-Security-Policy' => self::FRAME_ANCESTORS,
        ];

        if ($request->secure()) {
            $defaults['Strict-Transport-Security'] = 'max-age=31536000';
        }

        foreach ($defaults as $name => $value) {
            if (! $headers->has($name)) {
                $headers->set($name, $value);
            }
        }

        return $response;
    }
}
