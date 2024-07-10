<?php

function requireDir(string $dirName) {
    $dirFiles = scandir($dirName);

    foreach ($dirFiles as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $dirName . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                requireDir($filePath);
            } elseif (is_file($filePath)) {
                require_once $filePath;
            }
        }
    }
}

requireDir(__DIR__ . DIRECTORY_SEPARATOR . 'App');