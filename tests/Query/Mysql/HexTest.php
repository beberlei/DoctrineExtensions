<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class HexTest extends MysqlTestCase
{
    public function testHex()
    {
        $q = $this->entityManager->createQuery("SELECT HEX(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT HEX(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
