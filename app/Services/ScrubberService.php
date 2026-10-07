<?php

namespace App\Services;

class ScrubberService
{
    /**
     * Remove HTML tags from content.
     */
    public function cleanHtml(string $data): string
    {
        return strip_tags($data);
    }

    /**
     * Mask characters in an email address.
     *
     * Example:
     * john@example.com
     * j***@example.com
     */
    public function maskEmail(string $email): string
    {
        return preg_replace('/(?<=.).(?=.*@)/u', '*', $email) ?? $email;
    }

    /**
     * Remove special characters while keeping
     * letters, numbers and spaces.
     */
    public function removeSpecialChars(string $string): string
    {
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string) ?? $string;
    }

    /**
     * Mask phone number.
     *
     * Example:
     * 9876543210
     * 98******10
     */
    public function maskPhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (!$digits || strlen($digits) < 4) {
            return $phone;
        }

        $length = strlen($digits);

        $first = substr($digits, 0, 2);
        $last = substr($digits, -2);

        return $first . str_repeat('*', $length - 4) . $last;
    }

    /**
     * Sanitize URL.
     *
     * Removes dangerous javascript/data/vbscript protocols.
     */
    public function sanitizeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        $lowerUrl = strtolower($url);

        $dangerousProtocols = [
            'javascript:',
            'data:',
            'vbscript:',
        ];

        foreach ($dangerousProtocols as $protocol) {
            if (str_starts_with($lowerUrl, $protocol)) {
                return '';
            }
        }

        return filter_var($url, FILTER_SANITIZE_URL) ?: '';
    }

    /**
     * Trim leading and trailing whitespace.
     */
    public function trimWhitespace(string $string): string
    {
        return trim($string);
    }

    /**
     * Convert text to lowercase.
     */
    public function toLowercase(string $string): string
    {
        return strtolower($string);
    }

    /**
     * Convert text to uppercase.
     */
    public function toUppercase(string $string): string
    {
        return strtoupper($string);
    }

    /**
     * Normalize multiple spaces into a single space.
     */
    public function normalizeSpaces(string $string): string
    {
        return preg_replace('/\s+/', ' ', trim($string)) ?? $string;
    }

    /**
     * Encode HTML entities.
     *
     * Useful for safely displaying user-provided content.
     */
    public function encodeHtml(string $string): string
    {
        return htmlspecialchars(
            $string,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }

    /**
     * Process multiple lines.
     */
    public function bulkClean(array $lines, string $type): array
    {
        $results = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $results[] = $this->scrub($line, $type);
        }

        return $results;
    }

    /**
     * Process a single piece of content.
     */
    public function scrub(string $content, string $type): string
    {
        return match ($type) {

            // Existing features
            'html' => $this->cleanHtml($content),

            'email' => $this->maskEmail($content),

            'special' => $this->removeSpecialChars($content),

            // New features
            'phone' => $this->maskPhone($content),

            'url' => $this->sanitizeUrl($content),

            'trim' => $this->trimWhitespace($content),

            'lowercase' => $this->toLowercase($content),

            'uppercase' => $this->toUppercase($content),

            'spaces' => $this->normalizeSpaces($content),

            'html_encode' => $this->encodeHtml($content),

            default => $content,
        };
    }
}