<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Atan2Test extends MysqlTestCase
{
    public function testAtan2(): void
    {
        $this->assertDqlProducesSql(
            'SELECT ATAN2(2, 1) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT ATAN2(2, 1) AS sclr_0 FROM Blank b0_'
        );
    }
}
