<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class JulianDayTest extends SqliteTestCase
{
    public function testWithOneArgument(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JULIANDAY(:date) FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%J', ?) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
