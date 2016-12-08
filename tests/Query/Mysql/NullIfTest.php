<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class NullIfTest extends MysqlTestCase
{
    public function testNullIf()
    {
        $q = $this->entityManager->createQuery("SELECT NULLIF(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT NULLIF(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
