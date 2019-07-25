<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MakeDateTest extends MysqlTestCase
{
    public function testMakeDate()
    {
        $this->assertDqlProducesSql(
            "SELECT MAKEDATE(2019, 5) FROM DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT MAKEDATE(2019, 5) AS sclr_0 FROM Blank b0_'
        );
    }
}
