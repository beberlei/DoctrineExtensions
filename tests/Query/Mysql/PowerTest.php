<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class PowerTest extends MysqlTestCase
{
    public function testPower()
    {
        $q = $this->entityManager->createQuery("SELECT POWER(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT POWER(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
