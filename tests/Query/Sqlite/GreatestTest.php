<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class GreatestTest extends SqliteTestCase
{
    public function testGreatest()
    {
        $this->assertDqlProducesSql(
            "SELECT Greatest(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT MAX(2, 3) AS sclr_0 FROM Blank b0_'
        );
    }
}
