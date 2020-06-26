<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class MonthTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testMonth()
    {
        $this->assertDqlProducesSql(
            "SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%m', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
