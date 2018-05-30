<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class BinaryTest extends MysqlTestCase
{
    public function testBinary()
    {
        $this->assertDqlProducesSql(
            "SELECT BINARY('TEST') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT BINARY('TEST') AS sclr_0 FROM Blank b0_"
        );
    }
}
