<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class JulianDayTest extends SqliteTestCase
{
    public function testWithOneArgument()
    {
        $this->assertDqlProducesSql(
            "SELECT JULIANDAY(:date) FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT strftime('%J', ?) AS sclr_0 FROM Blank b0_"
        );
    }
}
