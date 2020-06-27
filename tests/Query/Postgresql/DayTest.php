<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class DayTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testDay()
    {
        $this->assertDqlProducesSql(
            "SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(DAY FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
