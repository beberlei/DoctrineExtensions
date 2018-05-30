<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class YearWeekTest extends MysqlTestCase
{
    public function testYearWeek()
    {
        $q = $this->entityManager->createQuery("SELECT YEARWEEK(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT YEARWEEK(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
