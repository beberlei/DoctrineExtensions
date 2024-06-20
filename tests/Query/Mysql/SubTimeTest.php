<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SubTimeTest extends MysqlTestCase
{
    public function testSubTime(): void
    {
        $this->assertDqlProducesSql(
            "SELECT SUBTIME('2024-04-04 19:35:00','01:22:33') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBTIME('2024-04-04 19:35:00', '01:22:33') AS sclr_0 FROM Blank b0_"
        );
    }
}
