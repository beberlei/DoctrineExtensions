<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MonthTest extends MysqlTestCase
{
    public function testMonth(): void
    {
        $this->assertDqlProducesSql(
            'SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT MONTH(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
