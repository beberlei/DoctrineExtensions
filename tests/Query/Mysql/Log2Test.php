<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Log2Test extends MysqlTestCase
{
    public function testLog2(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LOG2(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LOG2(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
