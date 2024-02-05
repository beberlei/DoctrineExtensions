<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Tests\Entities\Date;
use DoctrineExtensions\Tests\Query\OracleTestCase;

/** @author Jefferson Vantuir <jefferson.behling@gmail.com> */
class ToCharTest extends OracleTestCase
{
    public function testFullQuery(): void
    {
        $queryBuilder = new QueryBuilder($this->entityManager);
        $queryBuilder->select('TO_CHAR(d.created, \'DD-MON-YYYY HH24:MI:SSxFF\', \'german\')')
            ->from(Date::class, 'd');

        $sql = 'SELECT TO_CHAR(d0_.created, \'DD-MON-YYYY HH24:MI:SSxFF\', \'german\') AS sclr_0 FROM Date d0_';
        $this->assertEquals($sql, $queryBuilder->getQuery()->getSQL());
    }
}
