<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class UnhexTest extends MysqlTestCase
{
    public function testUnhex()
    {
        $q = $this->entityManager->createQuery("SELECT UNHEX(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT UNHEX(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
