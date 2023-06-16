<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class ConvTest extends MysqlTestCase
{
    public function testReplace(): void
    {
        $this->assertDqlProducesSql(
            "SELECT CONV('110', 2, 10) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONV('110', 2, 10) AS sclr_0 FROM Blank b0_"
        );
    }
}
