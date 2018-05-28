<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class InetAtonTest extends MysqlTestCase
{
    public function testInetAton()
    {
        $q = $this->entityManager->createQuery("SELECT INET_ATON('127.0.0.1') FROM DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT INET_ATON('127.0.0.1') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
