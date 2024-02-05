<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class YearTest extends SqliteTestCase
{
    public function testYear(): void
    {
        $this->assertDqlProducesSql(
            'SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank b',
            "SELECT CAST(STRFTIME('%Y', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
