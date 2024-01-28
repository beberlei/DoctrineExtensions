<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class StringTest extends PostgresqlTestCase
{
    public function testFormatDate(): void
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATE_FORMAT(p.created, :dateFormat) < :currentTime';
        $q   = $this->entityManager->createQuery($dql);
        $q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
        $q->setParameter('currentTime', 'YYYY-MM-DD');

        $this->assertEquals(
            'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE TO_CHAR(d0_.created, ?) < ?',
            $q->getSql()
        );
    }
}
