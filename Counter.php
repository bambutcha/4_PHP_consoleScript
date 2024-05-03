<?php
class Counter
{
    public const DEFAULT_FILE_NAME = 'counter.txt';

    protected $fileName = self::DEFAULT_FILE_NAME;
    protected $counterCountry = [];
    protected $counterText;

    public function __construct(?string $fileName)
    {
        $this->fileName = $fileName ?? self::DEFAULT_FILE_NAME;
    }

    public function handleCounter(Filter $filter): self
    {
        $replacements = [
            '%1' => count($filter->getAsianCity()),
            '%2' => count($filter->getEuCity()),
            '%3' => count($filter->getAfrCity()),
            '%4' => count($filter->getNaCity()),
            '%5' => count($filter->getSaCity()),
            '%6' => count($filter->getAuCity()),
        ];

        $template = "American cities:\n\t%1\n\nEuropean cities:\n\t%2\n\nAfrican cities:\n\t%3\n\nNorth American cities:\n\t%4\n\nSouth American cities:\n\t%5\n\nAustralian cities:\n\t%6";

        $this->counterText = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $template
        );

        return $this;
    }



    public function writeDataToCounter(string $outputDirectoryName): self
    {
            $outputFile = fopen("$outputDirectoryName/counter.txt", 'w');
            fwrite($outputFile, $this->counterText);
            fclose($outputFile);

            return $this;
    }
}
