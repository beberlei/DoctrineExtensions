<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class HourTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testHour()
    {
        $this->assertDqlProducesSql(
            "SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(HOUR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
