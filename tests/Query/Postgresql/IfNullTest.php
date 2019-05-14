<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class IfNullTest extends PostgresqlTestCase
{
    public function testIfNull()
    {
        $this->assertDqlProducesSql(
            'SELECT IFNULL(1, 2) FROM DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT IFNULL(1, 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
