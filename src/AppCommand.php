<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree;

use Exception;
use Gentree\InputFile\InputFileInterface;
use Gentree\OutputFile\OutputFileInterface;
use Gentree\Service\TreeBuilder;

/**
 * AppCommand class
 */
class AppCommand
{
    public const ERROR_ARGUMENTS_TEXT = 'Missing arguments(there should be 2 arguments)';
    public function __construct(
        private readonly InputFileInterface  $inputFileInterface,
        private readonly OutputFileInterface $outputFileInterface,
        private readonly TreeBuilder         $logicBuilder
    ) {

    }

    /**
     * Run command
     * @throws Exception
     */
    public function execute(string $inputFile, string $outputFile): void
    {
        $fileLines = $this->inputFileInterface->readFile($inputFile);
        $fileData = $this->logicBuilder->build($fileLines);
        $this->outputFileInterface->writeFile($outputFile, $fileData);
    }

    /**
     * Validate arguments for command
     * @throws Exception
     */
    public function validateArgs(array $arguments): void
    {
        if (!(isset($arguments[1]) && isset($arguments[2]))) {
            throw new Exception(self::ERROR_ARGUMENTS_TEXT);
        }

    }

}
