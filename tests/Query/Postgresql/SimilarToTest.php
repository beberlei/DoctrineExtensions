<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class SimilarToTest extends PostgresqlTestCase
{
    public function testHour(): void
    {
        $this->assertDqlProducesSql(
            "SELECT SIMILAR_TO('a', '^\a\') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT 'a' SIMILAR TO '^\a\' AS sclr_0 FROM Blank b0_"
        );
    }
}
