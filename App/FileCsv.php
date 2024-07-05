<?php

namespace App;
class FileCsv
{
    public const DEFAULT_FILE_FORMAT = 'csv';
    public const DEFAULT_OUTPUT_NAME = 'output';

    public function writeData(array $entityBody, string $fileName, array $headers): self
    {
        $fileName = implode('.', [$fileName, self::DEFAULT_FILE_FORMAT]);
        $outputFile = fopen(implode('/', [self::DEFAULT_OUTPUT_NAME, $fileName]), 'w');

        if (!$outputFile) {
            throw new Exception('Ошибка открытия файла');
        }

        fputcsv($outputFile, $headers);

        foreach ($entityBody as $entity) {
            fputcsv($outputFile, $entity);
        }
        fclose($outputFile);

        return $this;
    }

    public function prepareDir(?string $dirName): self
    {
        mkdir($dirName ?? self::DEFAULT_OUTPUT_NAME);
        return $this;
    }
}
