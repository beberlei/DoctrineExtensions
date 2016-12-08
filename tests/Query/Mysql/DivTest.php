<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DivTest extends MysqlTestCase
{
    public function testDiv()
    {
        $q = $this->entityManager->createQuery("SELECT DIV(2, 5) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT 2 DIV 5 AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
