<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class QuarterTest extends MysqlTestCase
{
    public function testQuarter()
    {
        $q = $this->entityManager->createQuery("SELECT QUARTER(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT QUARTER(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
