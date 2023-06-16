<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class QuarterTest extends SqliteTestCase
{
    public function testQuarter(): void
    {
        $this->assertDqlProducesSql(
            "SELECT QUARTER(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(((STRFTIME('%m', 2) + 2) / 3) as NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
