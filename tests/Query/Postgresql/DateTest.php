<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

class DateTest extends \DoctrineExtensions\Tests\Query\PostgresqlTestCase
{
    public function testStrToDate()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime";
        $q = $this->entityManager->createQuery($dql);
        $q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
        $q->setParameter('currentTime', date('Y-m-d H:i:s'));
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE TO_DATE(d0_.created, ?) < ?';

        $this->assertEquals($sql, $q->getSql());
    }
}
