<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class LimitTest extends SqliteTestCase
{
    public function testLimit(): void
    {
        $this->assertDqlProducesSql(
            'SELECT b0 FROM DoctrineExtensions\Tests\Entities\Blank b0 WHERE b0.id = LIMIT((SELECT b1 FROM DoctrineExtensions\Tests\Entities\Blank b1 ORDER BY b1.id DESC), 1)',
            'SELECT b0_.id AS id_0 FROM Blank b0_ WHERE b0_.id = (SELECT b1_.id FROM Blank b1_ ORDER BY b1_.id DESC LIMIT 1)'
        );
    }
}
