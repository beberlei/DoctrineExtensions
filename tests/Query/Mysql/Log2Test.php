<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class Log2Test extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testLog2()
    {
        $this->assertDqlProducesSql(
            "SELECT LOG2(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LOG2(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
