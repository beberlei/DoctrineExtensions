<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class HourTest extends PostgresqlTestCase
{
    public function testHour(): void
    {
        $this->assertDqlProducesSql(
            'SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(HOUR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
