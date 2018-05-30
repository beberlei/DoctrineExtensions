<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ConcatWsTest extends MysqlTestCase
{
    public function testConcatWs()
    {
        $this->assertDqlProducesSql(
            "SELECT CONCAT_WS(',', 'TEST', 'FOO') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONCAT_WS(',', 'TEST', 'FOO') AS sclr_0 FROM Blank b0_"
        );
    }
}
