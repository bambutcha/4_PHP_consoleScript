<?php

namespace App;

class FileHandler
{
    public const DEFAULT_OUTPUT_DIR_NAME = 'output';
    public const DEFAULT_OUTPUT_FORMAT = 'csv';

    protected function getFilePath(string $fileName, string $outputFileFormat): string
    {
        return implode(DIRECTORY_SEPARATOR, [self::DEFAULT_OUTPUT_DIR_NAME, $fileName . '.' . $outputFileFormat]);
    }

    public function prepareDir(?string $dirName = self::DEFAULT_OUTPUT_DIR_NAME): string
    {
        if (is_dir($dirName)) {
            return $dirName;
        }
        mkdir($dirName);
        return $dirName;
    }

    protected function getOutputName(string $fileName, string $outputFileFormat): string
    {
        $outputName = implode('.', [$fileName, $outputFileFormat]);
        return $outputName;
    }
}