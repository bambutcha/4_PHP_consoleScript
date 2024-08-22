<?php

namespace App;

class FileHandler
{
    public const DEFAULT_OUTPUT_DIR_NAME = 'output';
    public const DEFAULT_OUTPUT_FORMAT = 'csv';
    protected $outputFileFormat = '';
    public function __construct(?string $outputFileFormat = self::DEFAULT_OUTPUT_FORMAT)
    {
        $this->outputFileFormat = $outputFileFormat;
    }

    protected function getFilePath(string $fileName): string
    {
        return implode(DIRECTORY_SEPARATOR, [self::DEFAULT_OUTPUT_DIR_NAME, $fileName . '.' . $this->outputFileFormat]);
    }

    public function prepareDir(?string $dirName = self::DEFAULT_OUTPUT_DIR_NAME): string
    {
        if (is_dir($dirName)) {
            return $dirName;
        }
        mkdir($dirName);
        return $dirName;
    }
}