<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FieldTest extends MysqlTestCase
{
    public function testField(): void
    {
        $this->assertDqlProducesSql(
            'SELECT FIELD(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT FIELD(2, 3, 4) AS sclr_0 FROM Blank b0_'
        );
    }
}
