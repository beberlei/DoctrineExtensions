<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayTest extends MysqlTestCase
{
    public function testDay()
    {
        $this->assertDqlProducesSql(
            "SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT DAY(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
