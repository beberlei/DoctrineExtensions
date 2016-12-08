<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayNameTest extends MysqlTestCase
{
    public function testDayName()
    {
        $q = $this->entityManager->createQuery("SELECT DAYNAME(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DAYNAME(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
