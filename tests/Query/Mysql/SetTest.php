<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class SetTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testFindInSet()
    {

        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Set p WHERE FIND_IN_SET(p.id, p.set) != 0";
        $q = $this->entityManager->createQuery($dql);

        $idAlias = $this->getColumnAlias('id');
        $setAlias = $this->getColumnAlias('set', 1);

        $this->assertEquals(
            "SELECT s0_.id AS $idAlias, s0_.set AS $setAlias FROM Set s0_ WHERE FIND_IN_SET(s0_.id, s0_.set) <> 0",
            $q->getSql()
        );
    }
}
