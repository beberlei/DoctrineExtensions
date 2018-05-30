<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CotTest extends MysqlTestCase
{
    public function testCot()
    {
        $this->assertDqlProducesSql(
            "SELECT COT(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT COT(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
