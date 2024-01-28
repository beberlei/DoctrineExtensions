<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class DateTruncTest extends PostgresqlTestCase
{
    public function testDateTrunc(): void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("date_trunc('YEAR', dt.created)")
            ->from('DoctrineExtensions\Tests\Entities\Date', 'dt');

        $expected = "SELECT DATE_TRUNC('YEAR', d0_.created) AS sclr_0 FROM Date d0_";

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
