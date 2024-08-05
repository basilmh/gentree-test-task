<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\OutputFile;

/**
 * OutputJsonFile class
 */
class OutputJsonFile implements OutputFileInterface
{
    /**
     * {@inheritdoc}
     */
    public function writeFile(string $fileName, array $data): void
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $jsonData = mb_convert_encoding($jsonData, 'UTF-8');

        file_put_contents($fileName, $jsonData);
    }
}
