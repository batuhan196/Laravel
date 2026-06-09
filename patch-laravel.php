<?php

// ─── Patch 1: Str.php null byte fix ─────────────────────────────────────────
$file = __DIR__ . '/vendor/laravel/framework/src/Illuminate/Support/Str.php';
if (file_exists($file)) {
    $content = file_get_contents($file);
    $content = str_replace(
        '$trimDefaultCharacters = " \n\r\t\v\0";',
        '$trimDefaultCharacters = \' \n\r\t\v\0\';',
        $content
    );
    $content = str_replace(
        '$ltrimDefaultCharacters = " \n\r\t\v\0";',
        '$ltrimDefaultCharacters = \' \n\r\t\v\0\';',
        $content
    );
    $content = str_replace(
        '$rtrimDefaultCharacters = " \n\r\t\v\0";',
        '$rtrimDefaultCharacters = \' \n\r\t\v\0\';',
        $content
    );
    file_put_contents($file, $content);
    echo "Str.php patched successfully!\n";
} else {
    echo "Warning: Str.php not found, skipping.\n";
}

// ─── Patch 2: Container.php ReflectionFunction::isAnonymous() fix ────────────
$containerFile = __DIR__ . '/vendor/laravel/framework/src/Illuminate/Container/Container.php';
if (file_exists($containerFile)) {
    $content = file_get_contents($containerFile);
    $content = str_replace(
        '($reflector = new ReflectionFunction($callback(...)))->isAnonymous()',
        '(method_exists($reflector = new ReflectionFunction($callback(...)), \'isAnonymous\') ? $reflector->isAnonymous() : str_contains($reflector->getName(), \'{closure}\'))',
        $content
    );
    file_put_contents($containerFile, $content);
    echo "Container.php patched successfully!\n";
} else {
    echo "Warning: Container.php not found, skipping.\n";
}

// ─── Patch 3: Arr.php Random\Randomizer fix ───────────────────────────────────
// Laravel 12 uses Random\Randomizer (PHP 8.2+) in Arr::shuffle() and Arr::random()
// We patch it to use a polyfill-friendly approach for PHP 8.1
$arrFile = __DIR__ . '/vendor/laravel/framework/src/Illuminate/Collections/Arr.php';
if (file_exists($arrFile)) {
    $content = file_get_contents($arrFile);

    // Replace: new \Random\Randomizer() with a compat factory call
    $content = str_replace(
        'new \Random\Randomizer()',
        '(class_exists(\'\Random\Randomizer\') ? new \Random\Randomizer() : new \App\Support\FallbackRandomizer())',
        $content
    );

    file_put_contents($arrFile, $content);
    echo "Arr.php patched successfully!\n";
} else {
    echo "Warning: Arr.php not found, skipping.\n";
}

// ─── Patch 4: Find ALL usages of Random\Randomizer in vendor and patch ────────
$vendorDir = __DIR__ . '/vendor/laravel/framework/src';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($vendorDir));
$patched = 0;
foreach ($iterator as $fileInfo) {
    if ($fileInfo->getExtension() !== 'php') continue;
    $path = $fileInfo->getPathname();
    $src = file_get_contents($path);
    if (strpos($src, 'Random\Randomizer') === false) continue;

    // Replace direct instantiation
    $new = str_replace(
        'new \Random\Randomizer()',
        '(class_exists(\'\Random\Randomizer\') ? new \Random\Randomizer() : new \App\Support\FallbackRandomizer())',
        $src
    );
    $new = str_replace(
        'new Random\Randomizer()',
        '(class_exists(\'Random\Randomizer\') ? new Random\Randomizer() : new \App\Support\FallbackRandomizer())',
        $new
    );

    if ($new !== $src) {
        file_put_contents($path, $new);
        echo "Patched: $path\n";
        $patched++;
    }
}
echo "Total Random\\Randomizer patches applied: $patched\n";
