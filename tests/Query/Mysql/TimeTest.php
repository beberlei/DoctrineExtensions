<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimeTest extends MysqlTestCase
{
    public function testTime()
    {
        $q = $this->entityManager->createQuery("SELECT TIME(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT TIME(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
