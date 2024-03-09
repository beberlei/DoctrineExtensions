<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use DateTime;
use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Entities\Date;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class DateTruncTest extends PostgresqlTestCase
{
    public function testDateTrunc(): void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("date_trunc('YEAR', dt.created)")
            ->from('DoctrineExtensions\Tests\Entities\Date', 'dt');

        $expected = "SELECT DATE_TRUNC('YEAR'::text, d0_.created::timestamp) AS sclr_0 FROM Date d0_";

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testDateTruncCondition(): void
    {
        $queryBuilder = $this->entityManager->getRepository(Date::class)
            ->createQueryBuilder('dt')
            ->where("date_trunc('YEAR', dt.created) = date_trunc('YEAR', :date)")
            ->setParameter('date', new DateTime('2010-01-01'));

        $expected = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_TRUNC('YEAR'::text, d0_.created::timestamp) = DATE_TRUNC('YEAR'::text, ?::timestamp)";

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
