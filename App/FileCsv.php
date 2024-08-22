<?php

namespace App;

class FileCsv extends FileHandler
{

    protected $outputFileFormat = '';

    public function __construct(?string $outputFileFormat = self::DEFAULT_OUTPUT_FORMAT)
    {
        parent::__construct();
    }

    public function writeCsvData(array $entityBody, string $fileName, array $headers): self
    {
        $filePath = $this->getFilePath($fileName);
        $outputFile = fopen($filePath, 'w');

        if (!$outputFile) {
            throw new \Exception('Ошибка открытия файла');
        }

        fputcsv($outputFile, $headers);

        foreach ($entityBody as $entity) {
            fputcsv($outputFile, $entity);
        }
        fclose($outputFile);


        return $this;
    }

}

