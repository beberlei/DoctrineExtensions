<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class Age extends PostgresqlTestCase
{
    public function testAge()
    {
        $this->assertDqlProducesSql(
            "SELECT age('2012-03-05', '2010-04-01') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT age('2012-03-05', '2010-04-01') AS sclr_0 FROM Blank b0_"
        );
    }
}
