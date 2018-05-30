<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class AsciiTest extends MysqlTestCase
{
    public function testAscii()
    {
        $q = $this->entityManager->createQuery("SELECT ASCII(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ASCII(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
