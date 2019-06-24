<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class HexTest extends MysqlTestCase
{
    public function testHex()
    {
        $this->assertDqlProducesSql(
            "SELECT HEX(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT HEX(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
