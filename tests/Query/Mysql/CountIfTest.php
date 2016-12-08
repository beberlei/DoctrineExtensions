<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CountIfTest extends MysqlTestCase
{
    public function testCountIf()
    {
        $q = $this->entityManager->createQuery("SELECT COUNTIF(2, 3) from DoctrineExtensions\Tests\Entities\Blank");
        $this->assertEquals(
            "SELECT COUNT(CASE 2 WHEN 3 THEN 1 ELSE NULL END) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
    public function testCountIfInverse()
    {
        $q = $this->entityManager->createQuery("SELECT COUNTIF(2, 3 INVERSE) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT COUNT(CASE 2 WHEN 3 THEN NULL ELSE 1 END) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
