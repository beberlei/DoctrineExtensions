<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DegressTest extends MysqlTestCase
{
    public function testDegrees(): void
    {
        $this->assertDqlProducesSql(
            'SELECT DEGREES(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT DEGREES(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
