<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MatchAgainstTest extends MysqlTestCase
{
    public function testMatchAgainst()
    {
        $q = $this->entityManager->createQuery("SELECT MATCH(blank.id) AGAINST ('3') from DoctrineExtensions\Tests\Entities\Blank AS blank");

        $this->assertEquals(
            "SELECT MATCH (b0_.id) AGAINST ('3') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
