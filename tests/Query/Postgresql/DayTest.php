<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class DayTest extends PostgresqlTestCase
{
    public function testDay(): void
    {
        $this->assertDqlProducesSql(
            'SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(DAY FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
