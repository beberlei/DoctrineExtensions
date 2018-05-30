<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Sha1Test extends MysqlTestCase
{
    public function testSha1()
    {
        $q = $this->entityManager->createQuery("SELECT SHA1('2') from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT SHA1('2') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
