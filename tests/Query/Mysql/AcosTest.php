<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AcosTest extends MysqlTestCase
{
    public function testAcos()
    {
        $q = $this->entityManager->createQuery("SELECT ACOS(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ACOS(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
