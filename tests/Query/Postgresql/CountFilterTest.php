<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class CountFilterTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testCountFilter()
    {
        $dql = "SELECT COUNT(b) FILTER( WHERE b.id = :id) FROM DoctrineExtensions\Tests\Entities\Blank b";
        $q = $this->entityManager->createQuery($dql);
        $q->setParameter('id', 1);
        $sql = 'SELECT COUNT(b0_.id) FILTER( WHERE b0_.id = ?) FROM Blank b0_';
        $this->assertEquals($sql, $q->getSql());
    }
}
