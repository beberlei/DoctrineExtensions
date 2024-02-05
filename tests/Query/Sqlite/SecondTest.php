<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class SecondTest extends SqliteTestCase
{
    public function testSecond(): void
    {
        $this->assertDqlProducesSql(
            'SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b',
            "SELECT CAST(STRFTIME('%S', 2) AS NUMBER) AS sclr_0 FROM Blank b0_"
        );
    }
}
