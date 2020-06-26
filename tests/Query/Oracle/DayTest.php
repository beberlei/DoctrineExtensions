<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

class DayTest extends \DoctrineExtensions\Tests\Query\OracleTestCase
{
    public function testDay()
    {
        $this->assertDqlProducesSql(
            "SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(DAY FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
