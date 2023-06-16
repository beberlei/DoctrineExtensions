<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class AgeTest extends PostgresqlTestCase
{
    public function testAge(): void
    {
        $this->assertDqlProducesSql(
            "SELECT AGE('2012-03-05', '2010-04-01') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT AGE('2012-03-05', '2010-04-01') AS sclr_0 FROM Blank b0_"
        );
    }
}
