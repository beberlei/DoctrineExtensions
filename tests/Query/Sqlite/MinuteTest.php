<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class MinuteTest extends SqliteTestCase
{
    public function testMinute(): void
    {
        $this->assertDqlProducesSql(
            'SELECT MINUTE(2) from DoctrineExtensions\Tests\Entities\Blank b',
            "SELECT CAST(STRFTIME('%M', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
