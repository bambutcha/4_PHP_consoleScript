<?php

namespace App;

class FileCsvReader extends FileCsv
{
    protected $inputFileName;
    protected $headers;
    protected $entityList;

    public function __construct(string $inputFileName)
    {
        $this->inputFileName = $inputFileName;
    }

    public function handleInputFile(): self
    {
        $inputFileData = file($this->inputFileName);
        $this->headers = $this->handleEntity(array_shift($inputFileData));


        foreach ($inputFileData as $inputEntity) {
            $this->entityList[] = $this->handleEntity($inputEntity);
        }
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers ?? [];
    }

    public function getEntityList(): array
    {
        return $this->entityList ?? [];
    }

    protected function handleEntity(string $inputEntity): array
    {
        return array_map([$this, 'prepareEntityColumn'], explode(',', $inputEntity));
    }

    protected function prepareEntityColumn(string $value): string
    {
        return trim($value, '"' . PHP_EOL);
    }
}
