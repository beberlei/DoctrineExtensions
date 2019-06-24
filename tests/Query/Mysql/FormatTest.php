<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FormatTest extends MysqlTestCase
{
    public function testFormat()
    {
        $this->assertDqlProducesSql(
            "SELECT FORMAT(1000.00, 2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FORMAT(1000.00, 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
