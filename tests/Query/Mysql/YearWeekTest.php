<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class YearWeekTest extends MysqlTestCase
{
    public function testYearWeek()
    {
        $this->assertDqlProducesSql(
            "SELECT YEARWEEK(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT YEARWEEK(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
