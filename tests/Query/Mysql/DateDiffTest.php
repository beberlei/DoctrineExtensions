<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use Doctrine\ORM\Version;
use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DateDiffTest extends MysqlTestCase
{
    public function testDateDiff()
    {
        $q = $this->entityManager->createQuery("SELECT DATEDIFF('2017-06-25', '2017-06-15') from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT DATEDIFF('2017-06-25', '2017-06-15') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testDateDiffWithColumnAlias()
    {
        $q = $this->entityManager->createQuery("SELECT DATEADD(p.created, 1, 'DAY') as modified_date FROM DoctrineExtensions\Tests\Entities\Date as p WHERE DATEDIFF(CURRENT_TIME(), modified_date) < 7");

        $this->assertEquals(
            "SELECT DATE_ADD(d0_.created, INTERVAL 1 DAY) AS sclr_0 FROM Date d0_ WHERE DATEDIFF(CURRENT_TIME, sclr_0) < 7",
            $q->getSql()
        );
    }
}
