<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class MonthTest extends PostgresqlTestCase
{
    public function testMonth()
    {
        $this->assertDqlProducesSql(
            "SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(MONTH FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
