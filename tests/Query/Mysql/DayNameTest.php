<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayNameTest extends MysqlTestCase
{
    public function testDayName(): void
    {
        $this->assertDqlProducesSql(
            "SELECT DAYNAME(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT DAYNAME(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
