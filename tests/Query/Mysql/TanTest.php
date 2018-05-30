<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TanTest extends MysqlTestCase
{
    public function testTan()
    {
        $q = $this->entityManager->createQuery("SELECT TAN(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT TAN(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
