<?php

declare(strict_types=1);

namespace App\Services\DataFileProcessor;

use App\Exceptions\NoFileFoundException;
use App\Exceptions\NoFileParserException;
use App\Services\DataFileProcessor\FileParsers\FileParserInterface;
use Throwable;

class Records
{
    private iterable $records;

    /**
     * @param string $filePath The path to the data file
     * @throws NoFileParserException When no supported parser for the file
     * @throws NoFileFoundException When the file doesn't exist
     */
    public function __construct(string $filePath)
    {
        if (!\file_exists($filePath)) {
            throw new NoFileFoundException(\sprintf("File [%s] not found", $filePath));
        }
        $fileInfo = \pathinfo($filePath);

        // Try to get the supported records iterable for the file
        $parserClass = __NAMESPACE__ . '\\FileParsers\\' . strtoupper($fileInfo['extension']);
        try {
            $parser = new $parserClass($filePath);
            if ($parser instanceof FileParserInterface) {
                $this->records = $parser->records();
                return;
            }
        } catch (Throwable $e) {
            // Ignore this error block
        }
        // Throw an exception since No parser was found
        throw new NoFileParserException(sprintf(
            "[%s] file is currently not supported",
            strtoupper($fileInfo['extension'])
        ));
    }
    /**
     * Get the Records
     * @return iterable
     */
    public function get(): iterable
    {
        return $this->records;
    }
}
