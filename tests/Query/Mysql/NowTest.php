<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class NowTest extends MysqlTestCase
{
    public function testNow()
    {
        $this->assertDqlProducesSql(
            "SELECT NOW() from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT NOW() AS sclr_0 FROM Blank b0_'
        );
    }
}
