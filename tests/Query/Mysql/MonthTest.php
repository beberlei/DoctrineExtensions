<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MonthTest extends MysqlTestCase
{
    public function testMonth()
    {
        $q = $this->entityManager->createQuery("SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT MONTH(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
