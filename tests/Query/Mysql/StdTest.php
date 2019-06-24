<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class StdTest extends MysqlTestCase
{
    public function testStd()
    {
        $this->assertDqlProducesSql(
            "SELECT STD(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT STD(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
