<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class LeastTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testLeast()
    {
        $this->assertDqlProducesSql(
            "SELECT LEAST(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LEAST(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
