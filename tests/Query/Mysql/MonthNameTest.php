<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MonthNameTest extends MysqlTestCase
{
    public function testMonthName()
    {
        $q = $this->entityManager->createQuery("SELECT MONTHNAME(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT MONTHNAME(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
