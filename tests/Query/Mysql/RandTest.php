<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RandTest extends MysqlTestCase
{
    public function testRandWithParameter()
    {
        $q = $this->entityManager->createQuery("SELECT RAND(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT RAND(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testRandWithoutParameter()
    {
        $q = $this->entityManager->createQuery("SELECT RAND() from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT RAND() AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
