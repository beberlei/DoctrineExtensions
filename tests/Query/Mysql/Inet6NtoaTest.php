<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Inet6NtoaTest extends MysqlTestCase
{
    public function testInet6Ntoa()
    {
        $this->assertDqlProducesSql(
            "SELECT INET6_NTOA(INET6_ATON('2001:db8::b33f')) FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT INET6_NTOA(INET6_ATON('2001:db8::b33f')) AS sclr_0 FROM Blank b0_"
        );
    }
}
