<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

class HourTest extends \DoctrineExtensions\Tests\Query\OracleTestCase
{
    public function testHour()
    {
        $this->assertDqlProducesSql(
            "SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(HOUR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
