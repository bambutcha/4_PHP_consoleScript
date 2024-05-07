<?php

class Counter
{
    public const DEFAULT_FILE_NAME = 'output/counter.txt';

    protected $fileName = self::DEFAULT_FILE_NAME;
    protected $counterText;

    public function __construct(?string $fileName)
    {
        $this->fileName = $fileName ?? self::DEFAULT_FILE_NAME;
    }

    public function handleCounter(array $entities, string $counterText): self
    {
        $replacements = [
            '%1' => count($entities),
        ];

        $template = "$counterText:\n\t\t%1\n";

        $this->counterText = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $template
        );

        return $this;
    }


    public function writeDataToCounter(): self
    {
        $outputFile = fopen("$this->fileName", 'a');
        fwrite($outputFile, $this->counterText);
        fclose($outputFile);

        return $this;
    }

    public function clearCounterFile(): self
    {
        $counterFilePath = "$this->fileName.txt";

        if (file_exists($counterFilePath)) {
            file_put_contents($counterFilePath, '');
        }

        return $this;

    }
}
