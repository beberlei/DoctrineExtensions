<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FromUnixTimeTest extends MysqlTestCase
{
    public function testFromUnixTime()
    {
        $this->assertDqlProducesSql(
            "SELECT FROM_UNIXTIME(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FROM_UNIXTIME(2) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            "SELECT FROM_UNIXTIME(2,'%M-%Y') from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FROM_UNIXTIME(2,\'%M-%Y\') AS sclr_0 FROM Blank b0_'
        );
    }
}
