<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LastDayTest extends MysqlTestCase
{
    public function testLastDay(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LAST_DAY(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAST_DAY(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
