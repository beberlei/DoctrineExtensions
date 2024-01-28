<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RadiansTest extends MysqlTestCase
{
    public function testRadians(): void
    {
        $this->assertDqlProducesSql(
            'SELECT RADIANS(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT RADIANS(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
