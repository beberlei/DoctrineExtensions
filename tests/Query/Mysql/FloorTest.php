<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FloorTest extends MysqlTestCase
{
    public function testFloor()
    {
        $q = $this->entityManager->createQuery("SELECT FLOOR(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT FLOOR(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
