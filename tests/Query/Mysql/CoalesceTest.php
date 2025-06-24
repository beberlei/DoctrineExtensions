<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CoalesceTest extends MysqlTestCase
{
    public function testGreatest(): void
    {
        $this->assertDqlProducesSql(
            'SELECT COALESCE(2, 5, 8) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT COALESCE(2, 5, 8) AS sclr_0 FROM Blank b0_'
        );
    }
}
