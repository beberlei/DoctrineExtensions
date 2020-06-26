<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class YearTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testYear()
    {
        $this->assertDqlProducesSql(
            "SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(YEAR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
