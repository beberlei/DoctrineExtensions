<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LeastTest extends MysqlTestCase
{
    public function testLeast()
    {
        $q = $this->entityManager->createQuery("SELECT LEAST(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT LEAST(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
