<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Gentree\AppCommand;
use Gentree\InputFile\InputCsvFile;
use Gentree\OutputFile\OutputJsonFile;
use Gentree\Service\TreeBuilder;

try {
    $app = new AppCommand(
        new InputCsvFile(),
        new OutputJsonFile(),
        new TreeBuilder()
    );
    $app->validateArgs($argv);
    $app->execute($argv[1], $argv[2]);

} catch (Exception $e) {
    echo $e->getMessage();
}