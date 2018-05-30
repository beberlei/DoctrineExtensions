<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FindInSetTest extends MysqlTestCase
{
    public function testFindInSet()
    {
        $q = $this->entityManager->createQuery("SELECT FIND_IN_SET(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT FIND_IN_SET(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
