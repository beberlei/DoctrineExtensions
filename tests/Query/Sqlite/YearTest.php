<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class YearTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testYear()
    {
        $this->assertDqlProducesSql(
            "SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%Y', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
