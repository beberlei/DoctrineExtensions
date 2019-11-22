<?php

namespace DoctrineExtensions\Tests\Query\Postgresql;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Query\PostgresqlTestCase;

class StringAggTest extends PostgresqlTestCase
{
    public function testStringAgg()
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(bpt.latitude, '-')")
            ->from('DoctrineExtensions\Tests\Entities\BlogPost', 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(b0_.latitude, \'-\') AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggWithDistinct()
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(DISTINCT bpt.latitude, '-')")
            ->from('DoctrineExtensions\Tests\Entities\BlogPost', 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(DISTINCT b0_.latitude, \'-\') AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggWithOrderByClause()
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(bpt.latitude, '-' ORDER BY bpt.latitude)")
            ->from('DoctrineExtensions\Tests\Entities\BlogPost', 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(b0_.latitude, \'-\' ORDER BY b0_.latitude ASC) AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggWithOrderByClauseAndPredefinedDirectory()
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(bpt.latitude, '-' ORDER BY bpt.latitude DESC)")
            ->from('DoctrineExtensions\Tests\Entities\BlogPost', 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(b0_.latitude, \'-\' ORDER BY b0_.latitude DESC) AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }

    public function testStringAggFullDeclaration()
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder
            ->select("string_agg(DISTINCT bpt.latitude, '-' ORDER BY bpt.latitude DESC)")
            ->from('DoctrineExtensions\Tests\Entities\BlogPost', 'bpt')
            ->groupBy('bpt.created');

        $expected = 'SELECT string_agg(DISTINCT b0_.latitude, \'-\' ORDER BY b0_.latitude DESC) AS sclr_0 FROM BlogPost b0_ GROUP BY b0_.created';

        $this->assertEquals($expected, $queryBuilder->getQuery()->getSQL());
    }
}
