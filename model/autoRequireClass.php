<?php

spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/';
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base_dir)
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getFilename() === "$class.php") {
            require_once $file->getPathname();
            return;
        }
    }
});