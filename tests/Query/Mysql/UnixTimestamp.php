<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class UnixTimestamp extends MysqlTestCase
{
    public function testUnixTimeStampNoArguments()
    {
        $q = $this->entityManager->createQuery("SELECT UNIX_TIMESTAMP() from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT UNIX_TIMESTAMP() AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testUnixTimeStampOneArgument()
    {
        $q = $this->entityManager->createQuery("SELECT UNIX_TIMESTAMP(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT UNIX_TIMESTAMP(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
