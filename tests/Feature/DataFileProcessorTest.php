<?php

namespace Tests\Feature;

use App\Models\DataFile;
use App\Services\DataFileProcessor\Filters\AgeFilter;
use App\Services\DataFileProcessor\Processor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataFileProcessorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function allRecordsProcessedAndSaved()
    {
        $dataFile = DataFile::factory()->make();
        $filter = new AgeFilter(18, 65);

        $process = new Processor($dataFile, $filter);

        $this->assertSame(10001, $process->getRecordsProcessed());

        $this->assertDatabaseHas('customers', [
            'name' => 'Mrs. Daphney Borer',
        ]);
    }
}
