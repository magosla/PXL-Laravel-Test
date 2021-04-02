<?php

namespace App\Jobs;

use App\Models\DataFile;
use App\Services\DataFileProcessor\Filters\AgeFilter;
use App\Services\DataFileProcessor\Processor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDataFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     * @param DataFile $dataFile DataFile with job information
     *
     * @return void
     */
    public function __construct(private DataFile $dataFile)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filter = new AgeFilter(18, 65);
        new Processor($this->dataFile, $filter);
    }
}
