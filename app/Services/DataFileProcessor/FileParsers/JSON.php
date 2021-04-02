<?php

declare(strict_types=1);

namespace App\Services\DataFileProcessor\FileParsers;

use JsonMachine\JsonMachine;

class JSON implements FileParserInterface
{

    private iterable $records;

    public function __construct(string $filePath)
    {
        /**
         * To prevent Exhausting available memory due to large filesize
         * JsonMachine library is used to load the JSON file
         * @link https://github.com/halaxa/json-machine */
        $records = JsonMachine::fromFile($filePath);

        $this->records = $records;
    }

    public function records(): iterable
    {
        return $this->records;
    }
}
