<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Accepts a hostname, an IP address or an http(s) URL, i.e. something the
 * host probe can safely connect to. Other schemes and URLs with embedded
 * credentials are rejected.
 */
class HostAddress implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '' || preg_match('/\s/', $value) === 1) {
            $fail('The :attribute must be a hostname, an IP address or an http(s) URL.');

            return;
        }

        $candidate = str_contains($value, '://') ? $value : 'http://'.$value;
        $parts = parse_url($candidate);

        if ($parts === false
            || ! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)
            || empty($parts['host'])
            || array_key_exists('user', $parts)
            || array_key_exists('pass', $parts)) {
            $fail('The :attribute must be a hostname, an IP address or an http(s) URL.');
        }
    }
}
