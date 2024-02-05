<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

class HourTest extends OracleTestCase
{
    public function testHour(): void
    {
        $this->assertDqlProducesSql(
            'SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(HOUR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
