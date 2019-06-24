<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class StdDevTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testStdDev()
    {
        $this->assertDqlProducesSql(
            "SELECT STDDEV(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT STDDEV(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
