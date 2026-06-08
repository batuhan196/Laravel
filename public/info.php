<?php
header('Content-Type: text/plain');
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PCRE Version: " . (defined('PCRE_VERSION') ? PCRE_VERSION : 'not defined') . "\n";
