<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TruncateTest extends MysqlTestCase
{
    public function testFormat()
    {
        $this->assertDqlProducesSql(
            "SELECT TRUNCATE(1000.00, 2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT TRUNCATE(1000.00, 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
