<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CeilTest extends MysqlTestCase
{
    public function testCeil()
    {
        $q = $this->entityManager->createQuery("SELECT CEIL(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CEIL(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
