<?php

namespace Database\Factories;

use App\Models\DataFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file_path'=> storage_path('/data_files/challenge.json'),
        ];
    }
}
