<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RadiansTest extends MysqlTestCase
{
    public function testRadians()
    {
        $q = $this->entityManager->createQuery("SELECT RADIANS(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT RADIANS(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
