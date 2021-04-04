<?php

namespace Tests\Feature;

use App\Services\DataFileProcessor\Filters\AgeFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgeFilterTest extends TestCase
{

    /**
     * @test
     */
    public function rejectAgeOutOfRange()
    {
        $filter = new AgeFilter(18, 65, false);
        $data["date_of_birth"] = "2010-03-21T01:11:13+00:00";

        // reject when younger than 18
        $this->assertSame(null, $filter->filter($data));

        $data["date_of_birth"] = "1945-03-21T01:11:13+00:00";
        // reject when older than 65
        $this->assertSame(null, $filter->filter($data));
    }
    /**
     * @test
     */
    public function allowAgeWithinRange()
    {   
        $filter = new AgeFilter(18, 65, false);
        $data["date_of_birth"] = "1989-03-21T01:11:13+00:00";

        $this->assertSame($data, $filter->filter($data));
    }
    /**
     * @test
     */
    public function allowUnknownAge()
    {        
        $data["date_of_birth"] = "";

        $filter = new AgeFilter(0, 0, true);

        // when date of birth is empty
        $this->assertSame($data, $filter->filter($data));
        
        // when date of birth is null
        $data["date_of_birth"] = null;
        $this->assertSame($data, $filter->filter($data));

        
        // when date of birth is invalid
        $data["date_of_birth"] = 'sdsd';
        $this->assertSame($data, $filter->filter($data));
    }
}
