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

    public function testMatchAgainstMultipleFields()
    {
        $this->assertDqlProducesSql(
            "SELECT MATCH(post.longitude, post.latitude) AGAINST ('3') from DoctrineExtensions\Tests\Entities\BlogPost AS post",
            "SELECT MATCH (b0_.longitude, b0_.latitude) AGAINST ('3') AS sclr_0 FROM BlogPost b0_"
        );
    }

    public function testMatchAgainstInBooleanMode()
    {
        $this->assertDqlProducesSql(
            "SELECT MATCH(blank.id) AGAINST ('+3 -4' BOOLEAN) from DoctrineExtensions\Tests\Entities\Blank AS blank",
            "SELECT MATCH (b0_.id) AGAINST ('+3 -4' IN BOOLEAN MODE) AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT MATCH(blank.id) AGAINST ('+3 -4' IN BOOLEAN MODE) from DoctrineExtensions\Tests\Entities\Blank AS blank",
            "SELECT MATCH (b0_.id) AGAINST ('+3 -4' IN BOOLEAN MODE) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testMatchAgainstWithQueryExpansion()
    {
        $this->assertDqlProducesSql(
            "SELECT MATCH(blank.id) AGAINST ('3' EXPAND) from DoctrineExtensions\Tests\Entities\Blank AS blank",
            "SELECT MATCH (b0_.id) AGAINST ('3' WITH QUERY EXPANSION) AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT MATCH(blank.id) AGAINST ('3' WITH QUERY EXPANSION) from DoctrineExtensions\Tests\Entities\Blank AS blank",
            "SELECT MATCH (b0_.id) AGAINST ('3' WITH QUERY EXPANSION) AS sclr_0 FROM Blank b0_"
        );
    }
}
