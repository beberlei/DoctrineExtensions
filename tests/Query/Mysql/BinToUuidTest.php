<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class BinToUuidTest extends MysqlTestCase
{
    public function testBinToUuid()
    {
        $this->assertDqlProducesSql(
            "SELECT BIN_TO_UUID(b.id) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT BIN_TO_UUID(b0_.id) AS sclr_0 FROM Blank b0_"
        );
    }
}
