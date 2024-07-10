<?php

/**function requireDir($dirName, $className)
{
    $dirFiles = scandir($dirName);

    foreach ($dirFiles as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $dirName . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                requireDir($filePath, $className);
            } elseif (is_file($filePath) && basename($filePath, '.php') === $className) {
                require_once $filePath;
            }
        }
    }
}
 **/

function requireDir($dirName)
{
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

// Вызываем функцию для загрузки всех файлов в директории 'App'
requireDir(__DIR__ . DIRECTORY_SEPARATOR . 'App');


