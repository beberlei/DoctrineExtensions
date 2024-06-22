<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ModTest extends MysqlTestCase
{
    public function testMod()
    {
        $this->assertDqlProducesSql(
            "SELECT MOD(10, 4) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT 10 MOD 4 AS sclr_0 FROM Blank b0_'
        );
    }
}
