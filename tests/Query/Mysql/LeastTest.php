<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LeastTest extends MysqlTestCase
{
    public function testLeast()
    {
        $this->assertDqlProducesSql(
            "SELECT LEAST(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LEAST(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
