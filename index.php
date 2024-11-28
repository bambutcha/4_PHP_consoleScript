<?php

require 'vendor/autoload.php';

try {
    \App\Application::getInstance()->run($argv);
} catch (Exception $e) {
    echo $e->getMessage();
}
