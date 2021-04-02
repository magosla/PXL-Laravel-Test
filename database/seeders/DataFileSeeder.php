<?php

namespace Database\Seeders;

use App\Models\DataFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DataFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataFile::create([
            'id'=> 1,
            'file_path'=> storage_path('/data_files/challenge.json'),
        ]);
    }
}
