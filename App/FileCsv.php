<?php

namespace App;
class FileCsv
{
    public const DEFAULT_FILE_FORMAT = 'csv';
    public const DEFAULT_OUTPUT_DIR_NAME = 'output';

    public function writeData(array $entityBody, string $fileName, array $headers): self
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

    public function prepareDir(?string $dirName = self::DEFAULT_OUTPUT_DIR_NAME): string
    {
        if (is_dir($dirName)) {
            return $dirName;
        }
        mkdir($dirName);
        return $dirName;
    }

    private function getFilePath(string $fileName): string
    {
        return implode(DIRECTORY_SEPARATOR, [self::DEFAULT_OUTPUT_DIR_NAME, $fileName . '.' . self::DEFAULT_FILE_FORMAT]);
    }

}

