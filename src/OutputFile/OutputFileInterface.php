<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\OutputFile;

/**
 * OutputFileInterface interface
 */
interface OutputFileInterface
{
    /**
     * save data to file
     */
    public function writeFile(string $fileName, array $data): void;
}
