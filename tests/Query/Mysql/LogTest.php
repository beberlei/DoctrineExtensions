<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class LogTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testLog()
    {
        $this->assertDqlProducesSql(
            "SELECT LOG(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LOG(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
