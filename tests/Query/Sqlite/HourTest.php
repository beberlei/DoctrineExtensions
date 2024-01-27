<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class HourTest extends SqliteTestCase
{
    public function testHour()
    {
        $this->assertDqlProducesSql(
            "SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%H', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
