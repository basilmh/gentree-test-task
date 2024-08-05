<?php
/**
 * @author    Vasyl Minikh <mhbasil1@gmail.com>
 * @copyright 2024
 */
declare(strict_types=1);

namespace Gentree\Tests;

use Exception;
use Gentree\AppCommand;
use Gentree\InputFile\InputCsvFile;
use Gentree\OutputFile\OutputJsonFile;
use Gentree\Service\TreeBuilder;
use PHPUnit\Framework\TestCase;

/**
 * AppCommandTest class
 */
class AppCommandTest extends TestCase
{
    const  INPUT_FILE_NAME = __DIR__ . '/../../input.csv';
    const  ETHALON_FILE_NAME = __DIR__ . '/../../output-ethalon.json';
    const  OUTPUT_FILE_NAME = __DIR__ . '/../../output.json';

    protected function setUp(): void
    {
        $inputFileInterface = $this->getMockBuilder(InputCsvFile::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();
        $outputFileInterface = $this->getMockBuilder(OutputJsonFile::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();
        $logicBuilder = $this->getMockBuilder(TreeBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();
        $this->appCommand = $this->getMockBuilder(AppCommand::class)
            ->setConstructorArgs(
                [
                    'inputFileInterface' => $inputFileInterface,
                    'outputFileInterface' => $outputFileInterface,
                    'logicBuilder' => $logicBuilder
                ]
            )
            ->onlyMethods([])
            ->getMock();

    }

    /**
     * @throws Exception
     */
    public function testExecuteWithWrongParams(): void
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage(AppCommand::ERROR_ARGUMENTS_TEXT);
        $this->appCommand->validateArgs($this->getWrongCommandArguments());

    }

    /**
     * @throws Exception
     */
    public function testExecute(): void
    {
        $rightArgs = $this->getRightCommandArguments();

        $this->appCommand->validateArgs($rightArgs);

        $this->appCommand->execute($rightArgs[1], $rightArgs[2]);
        self::assertJsonFileEqualsJsonFile(self::OUTPUT_FILE_NAME, self::ETHALON_FILE_NAME);

    }

    private function getRightCommandArguments(): array
    {
        return ['filename.php', self::INPUT_FILE_NAME, self::OUTPUT_FILE_NAME];
    }

    private function getWrongCommandArguments(): array
    {
        return ['filename.php', self::OUTPUT_FILE_NAME];
    }
}
