<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

use function date;

class DateTest extends PostgresqlTestCase
{
    public function testStrToDate(): void
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime';
        $q   = $this->entityManager->createQuery($dql);
        $q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
        $q->setParameter('currentTime', date('Y-m-d H:i:s'));
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE TO_DATE(d0_.created, ?) < ?';

        $this->assertEquals($sql, $q->getSql());
    }

    public function testDateFunction(): void
    {
        $dql = 'SELECT DATE(p.created) FROM DoctrineExtensions\Tests\Entities\Date p';
        $sql = 'SELECT DATE(d0_.created) AS sclr_0 FROM Date d0_';

        $this->assertDqlProducesSql($dql, $sql);
    }
}
