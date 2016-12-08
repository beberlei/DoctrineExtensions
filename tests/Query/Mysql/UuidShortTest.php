<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class UuidShortTest extends MysqlTestCase
{
    public function testUuidShort()
    {
        $q = $this->entityManager->createQuery("SELECT UUID_SHORT() from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT UUID_SHORT() AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
