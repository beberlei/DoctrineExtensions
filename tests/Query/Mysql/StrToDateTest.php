<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class StrToDateTest extends MysqlTestCase
{
    public function testStrToDate()
    {
        $this->assertDqlProducesSql(
            "SELECT STR_TO_DATE(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT STR_TO_DATE(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
