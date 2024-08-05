<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\InputFile;

use Exception;
use Iterator;

/**
 * InputCsv class
 */
class InputCsvFile implements InputFileInterface
{
    public const SEPARATOR = ';';
    public const ENCLOSURE = '"';

    /**
     * read csv data
     *
     * @throws Exception
     */
    public function readFile(string $fileName): Iterator
    {
        $handle = fopen($fileName, "r");
        if ($handle === false) {
            throw new Exception("File " . $fileName . " not found");
        }
        $keys = fgetcsv($handle, 0, self::SEPARATOR, self::ENCLOSURE);
        while (($values = fgetcsv($handle, 0, self::SEPARATOR, self::ENCLOSURE)) !== false) {
            yield array_combine($keys, $values);
        }

        fclose($handle);
    }
}
