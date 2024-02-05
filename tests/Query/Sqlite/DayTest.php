<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class DayTest extends SqliteTestCase
{
    public function testDay(): void
    {
        $this->assertDqlProducesSql(
            'SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b',
            "SELECT CAST(STRFTIME('%d', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
