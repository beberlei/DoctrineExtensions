<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CosTest extends MysqlTestCase
{
    public function testCos()
    {
        $q = $this->entityManager->createQuery("SELECT COS(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT COS(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
