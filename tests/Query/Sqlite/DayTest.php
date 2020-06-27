<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class DayTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testDay()
    {
        $this->assertDqlProducesSql(
            "SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%d', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
