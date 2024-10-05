<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RowNumberTest extends MysqlTestCase
{
    public function testRowNumber(): void
    {
        $this->assertDqlProducesSql(
            'SELECT ROW_NUMBER() from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT ROW_NUMBER() AS sclr_0 FROM Blank b0_'
        );
    }
}
