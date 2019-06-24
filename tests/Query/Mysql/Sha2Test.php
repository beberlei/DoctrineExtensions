<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Sha2Test extends MysqlTestCase
{
    public function testSha2()
    {
        $this->assertDqlProducesSql(
            "SELECT SHA2('2', 2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SHA2('2',2) AS sclr_0 FROM Blank b0_"
        );
    }
}
