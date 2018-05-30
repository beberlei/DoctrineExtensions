<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class BitXorTest extends MysqlTestCase
{
    public function testBitCount()
    {
        $this->assertDqlProducesSql(
            "SELECT BIT_XOR(2, 2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT 2 ^ 2 AS sclr_0 FROM Blank b0_'
        );
    }
}
