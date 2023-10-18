<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class CastTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testCast()
    {
        $this->assertDqlProducesSql(
            "SELECT CAST(p.created AS timestamp) as casted from DoctrineExtensions\Tests\Entities\Product p",
            'SELECT CAST(p0_.created AS timestamp) AS sclr_0 FROM Product p0_'
        );
    }
}
