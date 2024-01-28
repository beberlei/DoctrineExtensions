<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class WeekOfYearTest extends MysqlTestCase
{
    public function testWeekOfYear(): void
    {
        $this->assertDqlProducesSql(
            'SELECT WEEKOFYEAR(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT WEEKOFYEAR(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
