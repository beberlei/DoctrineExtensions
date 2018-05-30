<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AtanTest extends MysqlTestCase
{
    public function testAtan()
    {
        $this->assertDqlProducesSql(
            "SELECT ATAN(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ATAN(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
