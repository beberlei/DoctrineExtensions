<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RightTest extends MysqlTestCase
{
    public function testRight(): void
    {
        $this->assertDqlProducesSql(
            'SELECT RIGHT(b.id, 1) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT RIGHT(b0_.id, 1) AS sclr_0 FROM Blank b0_'
        );
    }
}
