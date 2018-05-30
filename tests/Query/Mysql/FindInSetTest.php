<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FindInSetTest extends MysqlTestCase
{
    public function testFindInSet()
    {
        $this->assertDqlProducesSql(
            "SELECT FIND_IN_SET(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FIND_IN_SET(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
