<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class MonthTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testMonth()
    {
        $this->assertDqlProducesSql(
            "SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(MONTH FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
