<?php

namespace App;

class FileCsv extends FileHandler
{

    protected $outputFileFormat = '';

    public function __construct(?string $outputFileFormat = self::DEFAULT_OUTPUT_FORMAT)
    {
        $this->outputFileFormat = $outputFileFormat;
    }

    public function writeData(array $entityBody, string $fileName, array $headers): FileHandler
    {
        $filePath = $this->getFilePath($fileName, $this->outputFileFormat);
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
