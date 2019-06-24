<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SinTest extends MysqlTestCase
{
    public function testSin()
    {
        $this->assertDqlProducesSql(
            "SELECT SIN(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT SIN(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
