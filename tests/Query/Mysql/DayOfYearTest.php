<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayOfYearTest extends MysqlTestCase
{
    public function testDayOfYear(): void
    {
        $this->assertDqlProducesSql(
            "SELECT DAYOFYEAR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT DAYOFYEAR(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
