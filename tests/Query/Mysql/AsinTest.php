<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AsinTest extends MysqlTestCase
{
    public function testAsin()
    {
        $q = $this->entityManager->createQuery("SELECT ASIN(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ASIN(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
