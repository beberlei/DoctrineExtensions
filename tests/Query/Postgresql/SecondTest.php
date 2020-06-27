<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class SecondTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testSecond()
    {
        $this->assertDqlProducesSql(
            "SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FLOOR(EXTRACT(SECOND FROM 2)) AS sclr_0 FROM Blank b0_'
        );
    }
}
