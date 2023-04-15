<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class IlikeTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testILike()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Product p WHERE ILIKE(p.name, :searchName) = true";
        $q = $this->entityManager->createQuery($dql);
        $q->setParameter('searchName', '%search term%');
        $sql = 'SELECT p0_.id AS id_0, p0_.name AS name_1, p0_.created AS created_2, p0_.price AS price_3, p0_.weight AS weight_4 FROM Product p0_ WHERE (p0_.name ILIKE ?) = 1';

        $this->assertEquals($sql, $q->getSql());
    }
}
