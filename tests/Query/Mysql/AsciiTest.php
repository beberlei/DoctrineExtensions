<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AsciiTest extends MysqlTestCase
{
    public function testAscii(): void
    {
        $this->assertDqlProducesSql(
            "SELECT ASCII(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ASCII(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
