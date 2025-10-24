<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LeftTest extends MysqlTestCase
{
    public function testLeft(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LEFT(b.id, 2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEFT(b0_.id, 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
