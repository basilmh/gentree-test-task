<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\InputFile;

use Iterator;

/**
 * InputFileInterface interface
 */
interface InputFileInterface
{
    /**
     * read file data
     */
    public function readFile(string $fileName): Iterator;
}
