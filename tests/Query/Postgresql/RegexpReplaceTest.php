<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class RegexpReplaceTest extends PostgresqlTestCase
{
    public function testRegexpReplace(): void
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Set p WHERE REGEXP_REPLACE(p.set, '\d', 'X') LIKE 'testXXX'";
        $q   = $this->entityManager->createQuery($dql);

        $this->assertEquals(
            "SELECT s0_.id AS id_0, s0_.set AS set_1 FROM Set s0_ WHERE REGEXP_REPLACE(s0_.set, '\d', 'X') LIKE 'testXXX'",
            $q->getSql()
        );
    }
}
