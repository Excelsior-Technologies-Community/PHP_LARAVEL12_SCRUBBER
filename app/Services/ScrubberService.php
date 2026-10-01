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
     * Mask characters in an email address while preserving
     * the first and last character of the local part.
     */
    public function maskEmail(string $email): string
    {
        return preg_replace('/(?<=.).(?=.*@)/u', '*', $email) ?? $email;
    }

    /**
     * Remove special characters while keeping letters,
     * numbers and spaces.
     */
    public function removeSpecialChars(string $string): string
    {
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string) ?? $string;
    }

    /**
     * Process multiple lines using the selected scrub type.
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
            'html' => $this->cleanHtml($content),
            'email' => $this->maskEmail($content),
            'special' => $this->removeSpecialChars($content),
            default => $content,
        };
    }
}