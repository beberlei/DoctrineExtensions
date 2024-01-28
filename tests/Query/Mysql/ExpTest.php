<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ExpTest extends MysqlTestCase
{
    public function testExp(): void
    {
        $this->assertDqlProducesSql(
            'SELECT EXP(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXP(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
