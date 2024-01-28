<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class NullIfTest extends MysqlTestCase
{
    public function testNullIf(): void
    {
        $this->assertDqlProducesSql(
            'SELECT NULLIF(2, 3) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT NULLIF(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
