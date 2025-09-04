<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class NowTest extends PostgresqlTestCase
{
    public function testNow(): void
    {
        $this->assertDqlProducesSql(
            'SELECT NOW() from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT NOW() AS sclr_0 FROM Blank b0_'
        );
    }
}
