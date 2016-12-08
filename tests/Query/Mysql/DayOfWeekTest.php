<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayOfWeekTest extends MysqlTestCase
{
    public function testDayOfWeek()
    {
        $q = $this->entityManager->createQuery("SELECT DAYOFWEEK(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DAYOFWEEK(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
