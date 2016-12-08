<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class YearTest extends MysqlTestCase
{
    public function testYear()
    {
        $q = $this->entityManager->createQuery("SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT YEAR(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
