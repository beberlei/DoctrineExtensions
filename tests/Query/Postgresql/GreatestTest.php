<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class GreatestTest extends PostgresqlTestCase
{
    public function testGreatest(): void
    {
        $this->assertDqlProducesSql(
            'SELECT GREATEST(2, 5, 8) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT GREATEST(2, 5, 8) AS sclr_0 FROM Blank b0_'
        );
    }
}
