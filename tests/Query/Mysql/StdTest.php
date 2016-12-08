<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class StdTest extends MysqlTestCase
{
    public function testStd()
    {
        $q = $this->entityManager->createQuery("SELECT STD(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT STD(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
