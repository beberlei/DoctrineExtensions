<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class BitXorTest extends MysqlTestCase
{
    public function testBitCount()
    {
        $q = $this->entityManager->createQuery("SELECT BIT_XOR(2, 2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT 2 ^ 2 AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
