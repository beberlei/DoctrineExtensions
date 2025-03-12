<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class RandomTest extends PostgresqlTestCase
{
    public function testRandom(): void
    {
        $this->assertDqlProducesSql(
            'SELECT RANDOM() from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT RANDOM() AS sclr_0 FROM Blank b0_'
        );
    }
}
