<?php

namespace App\Services\DataFileProcessor\FileParsers;

interface FileParserInterface
{
    /**
     * The available records
     * @return iterable
     */
    public function records(): iterable;
}
