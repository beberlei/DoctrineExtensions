<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class SecondTest extends PostgresqlTestCase
{
    public function testSecond(): void
    {
        $this->assertDqlProducesSql(
            'SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT FLOOR(EXTRACT(SECOND FROM 2)) AS sclr_0 FROM Blank b0_'
        );
    }
}
