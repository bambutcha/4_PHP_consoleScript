<?php

<<<<<<<< HEAD:App/Handler/Counter.php
namespace App\Handler;
========
namespace App;
>>>>>>>> 8ceff2e (Create autoloader.php):App/Counter.php
class Counter
{
    public const DEFAULT_FILE_NAME = 'output/counter.txt';

    protected $fileName = self::DEFAULT_FILE_NAME;
    protected $counterText;

    public function __construct(?string $fileName = null)
    {
        $this->fileName = $fileName ?? self::DEFAULT_FILE_NAME;
    }

    public function prepareCounterText(array $entities, string $counterText): self
    {
        $this->counterText = str_replace("%1", PHP_EOL . "\t" . count($entities) . PHP_EOL, $counterText);

        return $this;
    }


    public function writeDataToCounter(): self
    {
        $outputFile = fopen($this->fileName, 'a');
        fwrite($outputFile, $this->counterText);
        fclose($outputFile);

        return $this;
    }

    public function clearCounterFile(): self
    {
        $counterFilePath = "$this->fileName";

        if (file_exists($counterFilePath)) {
            file_put_contents($counterFilePath, '');
        }

        return $this;

    }
}
