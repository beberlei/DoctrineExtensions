<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class IsIpv6Test extends MysqlTestCase
{
    public function testIsIpv6()
    {
        $this->assertDqlProducesSql(
            "SELECT IS_IPV6('2001:db8::dead:b33f') FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT IS_IPV6('2001:db8::dead:b33f') AS sclr_0 FROM Blank b0_"
        );
    }
}
