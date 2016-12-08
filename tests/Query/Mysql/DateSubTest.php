<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DateSubTest extends MysqlTestCase
{
    public function testDateSub()
    {
        $q = $this->entityManager->createQuery("SELECT DATESUB(2, 5, 'MINUTE') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DATE_SUB(2, INTERVAL 5 MINUTE) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
