<?php
<<<<<<< HEAD

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
=======
requireDir('App');

function requireDir(string $dirName) {
    $dirFiles = scandir($dirName);
    array_shift($dirFiles);
    array_shift($dirFiles);

    foreach ($dirFiles as $file) {
        require __DIR__ . DIRECTORY_SEPARATOR .implode(DIRECTORY_SEPARATOR, [$dirName, $file]);
    }
}
>>>>>>> 8ceff2e (Create autoloader.php)
