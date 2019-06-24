<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Log10Test extends MysqlTestCase
{
    public function testLog10()
    {
        $this->assertDqlProducesSql(
            "SELECT LOG10(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LOG10(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
