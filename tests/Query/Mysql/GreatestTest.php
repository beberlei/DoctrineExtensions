<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class GreatestTest extends MysqlTestCase
{
    public function testGreatest()
    {
        $q = $this->entityManager->createQuery("SELECT GREATEST(2, 5, 8) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT GREATEST(2, 5, 8) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
