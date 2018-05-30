<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Sha2Test extends MysqlTestCase
{
    public function testSha2()
    {
        $q = $this->entityManager->createQuery("SELECT SHA2('2', 2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SHA2('2',2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
