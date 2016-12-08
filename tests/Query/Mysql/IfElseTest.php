<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class IfElseTest extends MysqlTestCase
{
    public function testIfElse()
    {
        $q = $this->entityManager->createQuery("SELECT IFELSE(2 < 3, 4, 5) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT IF(2 < 3, 4, 5) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
