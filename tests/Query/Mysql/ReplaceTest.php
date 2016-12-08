<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ReplaceTest extends MysqlTestCase
{
    public function testReplace()
    {
        $q = $this->entityManager->createQuery("SELECT REPLACE(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT REPLACE(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
