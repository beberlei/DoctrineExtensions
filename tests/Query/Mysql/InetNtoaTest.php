<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class InetNtoaTest extends MysqlTestCase
{
    public function testInetNtoa()
    {
        $this->assertDqlProducesSql(
            "SELECT INET_NTOA('3221225985') FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT INET_NTOA('3221225985') AS sclr_0 FROM Blank b0_"
        );
    }
}
