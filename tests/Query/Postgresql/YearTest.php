<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class YearTest extends PostgresqlTestCase
{
    public function testYear(): void
    {
        $this->assertDqlProducesSql(
            'SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(YEAR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
