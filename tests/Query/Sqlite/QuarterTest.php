<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class QuarterTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testQuarter()
    {
        $this->assertDqlProducesSql(
            "SELECT QUARTER(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(((STRFTIME('%m', 2) + 2) / 3) as NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
