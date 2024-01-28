<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

use function date;

class AtTimeZoneTest extends PostgresqlTestCase
{
    public function testAtTimeZone(): void
    {
        $dql = 'SELECT d FROM DoctrineExtensions\Tests\Entities\Date d WHERE AT_TIME_ZONE(d.created, :timeZone) < :currentTime';
        $q   = $this->entityManager->createQuery($dql);
        $q->setParameter('timeZone', 'UTC');
        $q->setParameter('currentTime', date('Y-m-d H:i:s'));
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE d0_.created AT TIME ZONE ? < ?';
        $this->assertEquals($sql, $q->getSql());
    }
}
