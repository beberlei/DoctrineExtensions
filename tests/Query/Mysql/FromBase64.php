<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FromBase64 extends MysqlTestCase
{
    public function testFromBase64(): void
    {
        $this->assertDqlProducesSql(
            'SELECT FROM_BASE64(title) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT FROM_BASE64(title) AS sclr_0 FROM Blank b0_'
        );
    }
}
