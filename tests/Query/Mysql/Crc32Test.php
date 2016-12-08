<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Crc32Test extends MysqlTestCase
{
    public function testCrc32()
    {
        $q = $this->entityManager->createQuery("SELECT CRC32('TEST') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CRC32('TEST') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
