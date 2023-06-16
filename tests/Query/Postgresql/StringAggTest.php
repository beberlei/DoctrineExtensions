<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Entities\BlogPost;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

final class StringAggTest extends PostgresqlTestCase
{
    public function testStringAgg():void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(bpt.latitude, '-')")
            ->from(BlogPost::class, 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(b0_.latitude, \'-\') AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggWithDistinct():void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(DISTINCT bpt.latitude, '-')")
            ->from(BlogPost::class, 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(DISTINCT b0_.latitude, \'-\') AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggWithOrderByClause():void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(bpt.latitude, '-' ORDER BY bpt.latitude)")
            ->from(BlogPost::class, 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(b0_.latitude, \'-\' ORDER BY b0_.latitude ASC) AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggWithOrderByClauseAndPredefinedDirectory():void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(bpt.latitude, '-' ORDER BY bpt.latitude DESC)")
            ->from(BlogPost::class, 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(b0_.latitude, \'-\' ORDER BY b0_.latitude DESC) AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggFullDeclaration():void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(DISTINCT bpt.latitude, '-' ORDER BY bpt.latitude DESC)")
            ->from(BlogPost::class, 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(DISTINCT b0_.latitude, \'-\' ORDER BY b0_.latitude DESC) AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
