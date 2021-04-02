<?php

namespace Tests\Feature;

use App\Services\DataFileProcessor\Records;
use App\Exceptions\NoFileParserException;
use Tests\TestCase;

class DataFileRecordTest extends TestCase
{
    private string $dataFilePath;


    /**
     * A test to get the first record in the file.
     *
     * @test
     * @return void
     */
    public function firstRecordFetched()
    {
        $record = [];
        $file = \storage_path('data_files' . \DIRECTORY_SEPARATOR . 'challenge.json');

        $expected = \json_decode('{"name":"Prof. Simeon Green","address":"328 Bergstrom Heights Suite 709 49592 Lake Allenville","checked":false,"description":"Voluptatibus nihil dolor quaerat. Reprehenderit est molestias quia nihil consectetur voluptatum et.<br>Ea officiis ex ea suscipit dolorem. Ut ab vero fuga.<br>Quam ipsum nisi debitis repudiandae quibusdam. Sint quisquam vitae rerum nobis.","interest":null,"date_of_birth":"1989-03-21T01:11:13+00:00","email":"nerdman@cormier.net","account":"556436171909","credit_card":{"type":"Visa","number":"4532383564703","name":"Brooks Hudson","expirationDate":"12\/19"}}', true);

        $records = new Records($file);
        // get the first record if any
        foreach ($records->get() as $k => $d) {
            $record = $d;
            if ($k == 0) {
                $this->assertEquals($expected, $record);
            }
        }

        return $record;
    }

    /**
     * A test to see if unsupported files are rejectes
     * @test
     * @return void
     */
    public function noParserFound()
    {
        $this->expectException(NoFileParserException::class);

        $file = \storage_path('data_files' . \DIRECTORY_SEPARATOR . 'unsupported.xml');

        new Records($file);
    }

    /**
     * @param array $record 
     * @depends firstRecordFetched
     * @test
     */
    public function lastRecordFetched($record)
    {
        $expected = \json_decode('{"name":"Mrs. Daphney Borer","address":"57465 Kelton Trace Suite 676 49508-4359 Lake Iliana","checked":false,"description":"Quae quia at quae aut quaerat dolore consectetur. Quaerat saepe perferendis incidunt sapiente optio reiciendis. Rerum inventore et adipisci dolores possimus est voluptas qui.<br>Quis harum reiciendis ipsum. Aliquam quam commodi repellat occaecati. Aut et quam vel cumque eaque est.","interest":"leverage cross-media communities","date_of_birth":"1974-06-30T15:41:42+00:00","email":"flatley.laurie@damore.com","account":"2454926431051","credit_card":{"type":"Visa","number":"4532623545165","name":"Grace Kilback","expirationDate":"02\/18"}}', true);

        $this->assertEquals($expected, $record);
    }
}
