<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AtanTest extends MysqlTestCase
{
    public function testAtan()
    {
        $q = $this->entityManager->createQuery("SELECT ATAN(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ATAN(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
