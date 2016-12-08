<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class WeekDayTest extends MysqlTestCase
{
    public function testWeekDay()
    {
        $q = $this->entityManager->createQuery("SELECT WEEKDAY(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT WEEKDAY(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
