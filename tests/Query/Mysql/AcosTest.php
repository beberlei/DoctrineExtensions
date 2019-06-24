<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AcosTest extends MysqlTestCase
{
    public function testAcos()
    {
        $this->assertDqlProducesSql(
            "SELECT ACOS(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ACOS(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
