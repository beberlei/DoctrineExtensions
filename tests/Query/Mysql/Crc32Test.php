<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Crc32Test extends MysqlTestCase
{
    public function testCrc32()
    {
        $this->assertDqlProducesSql(
            "SELECT CRC32('TEST') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CRC32('TEST') AS sclr_0 FROM Blank b0_"
        );
    }
}
