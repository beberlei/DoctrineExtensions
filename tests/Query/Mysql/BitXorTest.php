<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class BitXorTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
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
