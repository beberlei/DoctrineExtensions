<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RpadTest extends MysqlTestCase
{
    public function testRpad()
    {
        $q = $this->entityManager->createQuery("SELECT RPAD(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT RPAD(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
