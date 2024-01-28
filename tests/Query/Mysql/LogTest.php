<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LogTest extends MysqlTestCase
{
    public function testLog(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LOG(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LOG(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
