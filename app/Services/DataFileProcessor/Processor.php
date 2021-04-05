<?php

declare(strict_types=1);

namespace App\Services\DataFileProcessor;

use App\Models\Customer;
use App\Models\DataFile;
use App\Exceptions\NotSavedException;
use App\Services\DataFileProcessor\Filters\FilterInterface;
use Illuminate\Support\Facades\DB;
use App\Services\DataFileProcessor\Records;

class Processor
{
    // Limit the number of records save per batch
    private const RECORDS_PER_SAVE = 1000;
    /**
     * The total number of records processed
     */
    private int $recordsProcessed;


    /**
     * @param DataFile $dataFile An instance of the dataFile Model which has the path to the data file
     * @param FilterInterface $filter Data filtering logic
     * 
     * @throws NotSavedException If failed to save data to database
     */
    public function __construct(private DataFile $dataFile, private FilterInterface $filter)
    {

        //Assign the records proceessed from previous processing (if any)
        $this->recordsProcessed = (int) $dataFile->records_processed;

        // process the file
        $this->processFile();
    }

    public function getRecordsProcessed()
    {
        return $this->recordsProcessed;
    }

    private function processFile()
    {
        // get the records from the file
        $records = (new Records($this->dataFile->file_path))->get();

        $this->processRecords($records, $this->recordsProcessed);
    }

    private function processRecords(iterable $records, $recordsToSkip)
    {
        $batch = []; // Needed to save record in batches
        foreach ($records as $record) {
            //skip any records that was previously processed   Fix: Record not skipped if available
            if ($recordsToSkip > 0 && $recordsToSkip-- > 0) {
                continue;
            }
            $this->recordsProcessed++;
            // Filter out what's not needed
            $record = $this->filter->filter($record);
            if ($record == \null) {
                continue;
            }

            $batch[] = $this->formatData($record);
            if (count($batch) == self::RECORDS_PER_SAVE) {
                $this->saveRecords($batch);
                $batch = [];
            }
        }
        // Save any batch that wasn't saved
        if (count($batch) > 0) {
            $this->saveRecords($batch);
        }
    }

    private function saveRecords(array $data)
    {
        try {
            $self = $this;
            DB::transaction(function () use ($data, $self) {

                Customer::insert($data);

                /* Update the dataFile model with the total records processed
                to keep track of what has been processed */
                $self->dataFile->update(['records_processed' => $self->recordsProcessed]);
            });
        } catch (\Throwable $e) {
            throw new NotSavedException($e->getMessage());
        }
    }


    private function formatData(array $record): array
    {
        // Serialize the credit card data to JSON string
        $record['credit_card'] = \json_encode($record['credit_card'] ?? []);

        // Format date_of_birth field to ensuse it's consistent with datetime
        if (\is_string($record['date_of_birth']) && ($timestamp = strtotime($record['date_of_birth'])) !== false) {
            $record['date_of_birth'] = date('Y-m-d H:i:s', $timestamp);
        } else {
            $record['date_of_birth'] = null;
        }
        return $record;
    }
}
