<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class StdDevTest extends MysqlTestCase
{
    public function testStdDev(): void
    {
        $this->assertDqlProducesSql(
            'SELECT STDDEV(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT STDDEV(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
