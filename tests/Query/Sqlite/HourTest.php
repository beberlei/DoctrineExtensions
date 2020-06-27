<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class HourTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testHour()
    {
        $this->assertDqlProducesSql(
            "SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%H', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
