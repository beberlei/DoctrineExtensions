<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use Doctrine\ORM\Version;

class DateTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testDateDiff()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEDIFF(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);
        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATEDIFF(CURRENT_TIME, d0_.created) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    public function testDateAdd()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), 4, 'MONTH') < 7";
        $q = $this->entityManager->createQuery($dql);
        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL 4 MONTH) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    public function testDateAddWithColumnAlias()
    {
        if(Version::VERSION < 2.2) {
            $this->markTestSkipped('Alias is not supported in Doctrine 2.1 and lower');
        }

        $dql = "SELECT p.created as alternative FROM DoctrineExtensions\Tests\Entities\Date p HAVING DATEADD(alternative, 4, 'MONTH') < 7";
        $q = $this->entityManager->createQuery($dql);
        $sql = "SELECT d0_.created AS created_0 FROM Date d0_ HAVING DATE_ADD(created_0, INTERVAL 4 MONTH) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    public function testDateAddWithNegative()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), -4, 'MONTH') < 7";
        $q = $this->entityManager->createQuery($dql);
        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL -4 MONTH) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    public function testDateSub()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATESUB(CURRENT_TIME(), 4, 'MONTH') < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_SUB(CURRENT_TIME, INTERVAL 4 MONTH) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    /**
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testDateAdd2()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);
        $sql = '';

        $this->assertEquals($sql, $q->getSql());
    }

    public function testFromUnixtime()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE FROM_UNIXTIME(CURRENT_TIME()) = '2000-01-01 00:00:00'";
        $q = $this->entityManager->createQuery($dql);
        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE FROM_UNIXTIME(CURRENT_TIME) = '2000-01-01 00:00:00'";

        $this->assertEquals($sql, $q->getSql());
    }

    public function testStrToDate()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime";
        $q = $this->entityManager->createQuery($dql);
        $q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
        $q->setParameter('currentTime', date('Y-m-d H:i:s'));
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE STR_TO_DATE(d0_.created, ?) < ?';

        $this->assertEquals($sql, $q->getSql());
    }

    public function testUnixTimpestamp()
    {
        $dql = "SELECT UNIX_TIMESTAMP(p.created) FROM DoctrineExtensions\Tests\Entities\Date p";
        $q = $this->entityManager->createQuery($dql);
        $sql = 'SELECT UNIX_TIMESTAMP(d0_.created) AS sclr_0 FROM Date d0_';

        $this->assertEquals($sql, $q->getSql());
    }
    
    public function testExtract()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE 201702 > EXTRACT(YEAR_MONTH FROM p.created)";
        $q = $this->entityManager->createQuery($dql);
        
        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE 201702 > EXTRACT(YEAR_MONTH FROM d0_.created)";

        $this->assertEquals($sql, $q->getSql());
    }
}
