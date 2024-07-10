<?php

requireDir('App');

function requireDir(string $dirName) {
    $dirFiles = scandir($dirName);
    array_shift($dirFiles);
    array_shift($dirFiles);

    foreach ($dirFiles as $file) {
        require __DIR__ . DIRECTORY_SEPARATOR .implode(DIRECTORY_SEPARATOR, [$dirName, $file]);
    }
}