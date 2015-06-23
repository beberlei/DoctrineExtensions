<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;


use DoctrineExtensions\Tests\Query\SqliteTestCase;

class DateTest extends SqliteTestCase
{

    public function _testDateDiff()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEDIFF(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT d0_.id AS id0, d0_.created AS created1 FROM Date d0_ WHERE DATEDIFF(CURRENT_TIME, d0_.created) < 7";
        $this->assertEquals($sql, $q->getSql());
    }

    public function _testDateAdd()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), 4, 'MONTH') < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT d0_.id AS id0, d0_.created AS created1 FROM Date d0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL 4 MONTH) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    /**
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function _testDateAdd2()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = '';

        $this->assertEquals($sql, $q->getSql());
    }

    public function _testStrToDate()
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime';
        $q = $this->entityManager->createQuery($dql);
        $q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
        $q->setParameter('currentTime', date('Y-m-d H:i:s'));

        $this->assertEquals(
            'SELECT d0_.id AS id0, d0_.created AS created1 FROM Date d0_ WHERE STR_TO_DATE(d0_.created, ?) < ?',
            $q->getSql()
        );
    }



}
