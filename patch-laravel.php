<?php
$file = __DIR__ . '/vendor/laravel/framework/src/Illuminate/Support/Str.php';
if (file_exists($file)) {
    $content = file_get_contents($file);
    
    // Replace double-quoted default characters with single-quoted ones to prevent raw null bytes
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
    echo "Error: Str.php not found!\n";
}

$containerFile = __DIR__ . '/vendor/laravel/framework/src/Illuminate/Container/Container.php';
if (file_exists($containerFile)) {
    $content = file_get_contents($containerFile);
    
    // Replace ReflectionFunction::isAnonymous() with a compatibility check
    $content = str_replace(
        '($reflector = new ReflectionFunction($callback(...)))->isAnonymous()',
        '(method_exists($reflector = new ReflectionFunction($callback(...)), \'isAnonymous\') ? $reflector->isAnonymous() : str_contains($reflector->getName(), \'{closure}\'))',
        $content
    );

    file_put_contents($containerFile, $content);
    echo "Container.php patched successfully!\n";
} else {
    echo "Error: Container.php not found!\n";
}

