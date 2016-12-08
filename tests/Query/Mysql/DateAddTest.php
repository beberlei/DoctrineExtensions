<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DateAddTest extends MysqlTestCase
{
    public function testDateAdd()
    {
        $q = $this->entityManager->createQuery("SELECT DATEADD(2, 5, 'MINUTE') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DATE_ADD(2, INTERVAL 5 MINUTE) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
