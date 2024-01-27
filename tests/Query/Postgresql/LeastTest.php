<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class LeastTest extends PostgresqlTestCase
{
    public function testLeast()
    {
        $this->assertDqlProducesSql(
            "SELECT LEAST(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LEAST(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
