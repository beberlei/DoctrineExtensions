<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SecondTest extends MysqlTestCase
{
    public function testSecond()
    {
        $q = $this->entityManager->createQuery("SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SECOND(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
