<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LpadTest extends MysqlTestCase
{
    public function testLpad()
    {
        $this->assertDqlProducesSql(
            "SELECT LPAD(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LPAD(2, 3, 4) AS sclr_0 FROM Blank b0_'
        );
    }
}
