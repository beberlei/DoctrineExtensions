<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

class SecondTest extends \DoctrineExtensions\Tests\Query\SqliteTestCase
{
    public function testSecond()
    {
        $this->assertDqlProducesSql(
            "SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CAST(STRFTIME('%S', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
