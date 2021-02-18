<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class ConcatWsTest extends PostgresqlTestCase
{
    public function testConcatWs()
    {
        $this->assertDqlProducesSql(
            "SELECT CONCAT_WS(',', 'TEST', 'FOO') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONCAT_WS(',', 'TEST', 'FOO') AS sclr_0 FROM Blank b0_"
        );
    }
}
