<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MatchAgainstTest extends MysqlTestCase
{
    public function testMatchAgainst()
    {
        $this->assertDqlProducesSql(
            "SELECT MATCH(blank.id) AGAINST ('3') from DoctrineExtensions\Tests\Entities\Blank AS blank",
            "SELECT MATCH (b0_.id) AGAINST ('3') AS sclr_0 FROM Blank b0_"
        );
    }
}
