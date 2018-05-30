<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AsinTest extends MysqlTestCase
{
    public function testAsin()
    {
        $this->assertDqlProducesSql(
            "SELECT ASIN(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ASIN(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
