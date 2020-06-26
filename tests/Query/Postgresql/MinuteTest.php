<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class MinuteTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testMinute()
    {
        $this->assertDqlProducesSql(
            "SELECT MINUTE(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
