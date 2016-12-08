<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SinTest extends MysqlTestCase
{
    public function testSin()
    {
        $q = $this->entityManager->createQuery("SELECT SIN(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SIN(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
