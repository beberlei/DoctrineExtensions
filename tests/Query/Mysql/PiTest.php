<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class PiTest extends MysqlTestCase
{
    public function testPi()
    {
        $q = $this->entityManager->createQuery("SELECT PI() from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT PI() AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
