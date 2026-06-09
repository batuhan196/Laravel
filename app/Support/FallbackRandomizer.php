<?php

namespace App\Support;

/**
 * PHP 8.1 compatibility shim for \Random\Randomizer (added in PHP 8.2).
 * Used automatically by patch-laravel.php when deploying to PHP 8.1 servers.
 */
class FallbackRandomizer
{
    /**
     * Pick $num random keys from an array.
     */
    public function pickArrayKeys(array $array, int $num): array
    {
        $keys  = array_keys($array);
        $count = count($keys);

        if ($num > $count) {
            throw new \ValueError('$num cannot be greater than the number of array elements.');
        }

        $picked = [];
        $used   = [];

        while (count($picked) < $num) {
            $index = mt_rand(0, $count - 1);
            if (! isset($used[$index])) {
                $used[$index] = true;
                $picked[]     = $keys[$index];
            }
        }

        return $picked;
    }

    /**
     * Shuffle an array and return it.
     */
    public function shuffleArray(array $array): array
    {
        shuffle($array);
        return $array;
    }

    /**
     * Shuffle a string's bytes and return it.
     */
    public function shuffleBytes(string $bytes): string
    {
        $arr = str_split($bytes);
        shuffle($arr);
        return implode('', $arr);
    }

    /**
     * Get a random integer between $min and $max (inclusive).
     */
    public function getInt(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }

    /**
     * Get $length cryptographically random bytes.
     */
    public function getBytes(int $length): string
    {
        return random_bytes($length);
    }

    /**
     * Get $length random bytes chosen from $string.
     */
    public function getBytesFromString(string $string, int $length): string
    {
        $chars  = str_split($string);
        $count  = count($chars);
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[mt_rand(0, $count - 1)];
        }

        return $result;
    }

    /**
     * Get a float between $min (inclusive) and $max (exclusive).
     */
    public function getFloat(float $min, float $max): float
    {
        return $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
    }
}
