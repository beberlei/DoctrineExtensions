<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class NowTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testNow()
    {
        $this->assertDqlProducesSql(
            "SELECT NOW() FROM DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT NOW() AS sclr_0 FROM Blank b0_'
        );
    }
}
