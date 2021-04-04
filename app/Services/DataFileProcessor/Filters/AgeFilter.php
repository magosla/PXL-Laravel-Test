<?php

declare(strict_types=1);

namespace App\Services\DataFileProcessor\Filters;

/**
 * Filter out where age doesn't meet provided criteria
 */
class AgeFilter implements FilterInterface
{
    /**
     * @param int $minAge the minimun age allowed
     * @param int $maxAge the maximum age allowed
     * @param bool $allowUnknownAge if to allow for age unknown
     */
    public function __construct(private int $minAge, private int $maxAge, private bool $allowUnknownAge = true)
    {
    }

    public function filter(array $data): ?array
    {
        $birthDate = $data['date_of_birth'] ?? null;

        // calculate the the age from provided data of birth
        $birthDateTime = $birthDate ? date_create($birthDate) : null;
        $age = $birthDateTime ? (date_diff($birthDateTime, date_create('today'))->y)
            : null;

        if ((!$age && $this->allowUnknownAge) || ($age >= $this->minAge && $age <= $this->maxAge)) {
            return $data;
        }
        return null;
    }
}
