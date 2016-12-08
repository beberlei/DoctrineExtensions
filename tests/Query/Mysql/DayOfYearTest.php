<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayOfYearTest extends MysqlTestCase
{
    public function testDayOfYear()
    {
        $q = $this->entityManager->createQuery("SELECT DAYOFYEAR(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DAYOFYEAR(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
