<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class DatePartTest extends PostgresqlTestCase
{
    public function testDatePart()
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("date_part('YEAR', dt.created)")
            ->from('DoctrineExtensions\Tests\Entities\Date', 'dt');

        $expected = "SELECT date_part('YEAR', t0_.latitude) AS sclr_0 FROM Date t0_ GROUP BY t0_.created";

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
