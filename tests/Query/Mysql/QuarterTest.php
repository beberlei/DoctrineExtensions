<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class QuarterTest extends MysqlTestCase
{
    public function testQuarter()
    {
        $this->assertDqlProducesSql(
            "SELECT QUARTER(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT QUARTER(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
