<?php

namespace App\Services\DataFileProcessor\Filters;


interface FilterInterface
{
    /**
     * Filter the provided data
     * @param array $data data to filter
     * @return returns the provided data if matches criteria or null otherwise
     */
    public function filter(array $data): ?array;
}
