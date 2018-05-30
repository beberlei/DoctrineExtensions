<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class IfNullTest extends MysqlTestCase
{
    public function testIfNull()
    {
        $q = $this->entityManager->createQuery("SELECT IFNULL(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT IFNULL(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
