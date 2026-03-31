<?php

namespace App\Services;

class ScrubberService
{
    public function cleanHtml($data) {
        return strip_tags($data);
    }

    public function maskEmail($email) {
        return preg_replace('/(?<=.).(?=.*@)/u', '*', $email);
    }

    public function removeSpecialChars($string) {
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string);
 
        }
        public function bulkClean($lines, $type) {
    $results = [];
    foreach ($lines as $line) {
        if (empty(trim($line))) continue;
        
        if ($type == 'html') {
            $results[] = $this->cleanHtml($line);
        } elseif ($type == 'email') {
            $results[] = $this->maskEmail($line);
        }
    }
    return $results;
}
}