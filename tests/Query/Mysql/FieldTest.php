<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FieldTest extends MysqlTestCase
{
    public function testField()
    {
        $q = $this->entityManager->createQuery("SELECT FIELD(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT FIELD(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
