<?php

function requireDir(string $dirName) {
    $dirFiles = scandir($dirName);

    if (!is_dir($dirName)) {
        throw new Exception("Директории '{$dirName}' не существует.");
    }

    foreach ($dirFiles as $file) {

        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $dirName . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            requireDir($filePath);
        } elseif (is_file($filePath)) {
            require_once $filePath;
        }
    }
}

requireDir(__DIR__ . DIRECTORY_SEPARATOR . 'App');
