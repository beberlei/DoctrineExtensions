<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LpadTest extends MysqlTestCase
{
    public function testLpad()
    {
        $q = $this->entityManager->createQuery("SELECT LPAD(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT LPAD(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
