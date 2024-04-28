<?php

class Counter
{
    public const DEFAULT_FILE_NAME = 'counter.txt';

    protected $fileName = self::DEFAULT_FILE_NAME;
    protected $counterCountry = [];
    protected $counterText;

    public function __construct(?array $counterCountry, ?string $fileName)
    {
        $this->fileName = $fileName ?? self::DEFAULT_FILE_NAME;
        $this->counterCountry = $counterCountry ?? [0,0,0,0,0,0];
    }

    public function handleCounter(): self
    {
            $this->counterText = implode(PHP_EOL, [
                "В Азии - {$this->counterCountry[0]} городов",
                "В Европе - {$this->counterCountry[1]} городов",
                "В Африке - {$this->counterCountry[2]} городов",
                "В Северной Америке - {$this->counterCountry[3]} городов",
                "В Южной Америке - {$this->counterCountry[4]} городов",
                "В Австралии - {$this->counterCountry[5]} городов"
            ]);

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
