<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class IfNullTest extends MysqlTestCase
{
    public function testIfNull()
    {
        $this->assertDqlProducesSql(
            "SELECT IFNULL(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT IFNULL(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
