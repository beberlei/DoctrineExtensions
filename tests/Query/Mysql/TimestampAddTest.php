<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimestampAddTest extends MysqlTestCase
{
    public function testTimestampAdd()
    {
        $this->assertDqlProducesSql(
            "SELECT TIMESTAMPADD(MINUTE, 1, '2003-01-02') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT TIMESTAMPADD(MINUTE, 1, '2003-01-02') AS sclr_0 FROM Blank b0_"
        );
    }
}
