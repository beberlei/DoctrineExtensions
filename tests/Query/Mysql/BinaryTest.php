<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class BinaryTest extends MysqlTestCase
{
    public function testBinary()
    {
        $q = $this->entityManager->createQuery("SELECT BINARY('TEST') from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT BINARY('TEST') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
