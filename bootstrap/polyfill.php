<?php

/**
 * PHP 8.1 Compatibility Polyfills
 * Loaded before anything else via bootstrap/app.php
 */

// ─── Random\Randomizer polyfill (PHP 8.2+) ───────────────────────────────────
namespace Random {
    if (! class_exists('Random\Randomizer', false)) {
        class Randomizer
        {
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

            public function shuffleArray(array $array): array
            {
                shuffle($array);
                return $array;
            }

            public function shuffleBytes(string $bytes): string
            {
                $arr = str_split($bytes);
                shuffle($arr);
                return implode('', $arr);
            }

            public function getInt(int $min, int $max): int
            {
                return mt_rand($min, $max);
            }

            public function getBytes(int $length): string
            {
                return random_bytes($length);
            }

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

            public function getFloat(float $min, float $max): float
            {
                return $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
            }
        }
    }
}

// ─── Global namespace helpers ─────────────────────────────────────────────────
namespace {
    // Placeholder for future global polyfills
}
