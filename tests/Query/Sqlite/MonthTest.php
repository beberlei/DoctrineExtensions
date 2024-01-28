<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class MonthTest extends SqliteTestCase
{
    public function testMonth(): void
    {
        $this->assertDqlProducesSql(
            'SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b',
            "SELECT CAST(STRFTIME('%m', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
