<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class MinuteTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testMinute()
    {
        $this->assertDqlProducesSql(
            "SELECT MINUTE(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%M', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
