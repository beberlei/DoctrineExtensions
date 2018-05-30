<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DateSubTest extends MysqlTestCase
{
    public function testDateSub()
    {
        $this->assertDqlProducesSql(
            "SELECT DATESUB(2, 5, 'MINUTE') from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT DATE_SUB(2, INTERVAL 5 MINUTE) AS sclr_0 FROM Blank b0_'
        );
    }
}
