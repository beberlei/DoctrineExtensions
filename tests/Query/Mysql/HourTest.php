<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class HourTest extends MysqlTestCase
{
    public function testHour()
    {
        $q = $this->entityManager->createQuery("SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT HOUR(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
