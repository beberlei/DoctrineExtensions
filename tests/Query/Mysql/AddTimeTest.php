<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AddTimeTest extends MysqlTestCase
{
    public function testDateAdd()
    {
        $this->assertDqlProducesSql(
            "SELECT ADDTIME('2019-03-01 14:35:00','01:02:03') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT ADDTIME('2019-03-01 14:35:00', '01:02:03') AS sclr_0 FROM Blank b0_"
        );
    }
}
