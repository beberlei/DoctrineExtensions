<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class RandomTest extends SqliteTestCase
{
    public function testRandom(): void
    {
        $this->assertDqlProducesSql(
            'SELECT RANDOM() from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT RANDOM() AS sclr_0 FROM Blank b0_'
        );
    }
}
