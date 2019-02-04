<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CosTest extends MysqlTestCase
{
    public function testCos(): void
    {
        $this->assertDqlProducesSql(
            "SELECT COS(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT COS(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
