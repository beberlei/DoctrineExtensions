<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Md5Test extends MysqlTestCase
{
    public function testMd5()
    {
        $q = $this->entityManager->createQuery("SELECT MD5('2') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT MD5('2') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
