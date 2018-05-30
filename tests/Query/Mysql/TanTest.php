<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TanTest extends MysqlTestCase
{
    public function testTan()
    {
        $this->assertDqlProducesSql(
            "SELECT TAN(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT TAN(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
