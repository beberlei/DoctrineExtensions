<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class WeekTest extends MysqlTestCase
{
    public function testWeek()
    {
        $this->assertDqlProducesSql(
            "SELECT WEEK(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT WEEK(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
