<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class NowTest extends MysqlTestCase
{
    public function testNow()
    {
        $q = $this->entityManager->createQuery("SELECT NOW() from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT NOW() AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
