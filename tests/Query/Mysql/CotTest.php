<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CotTest extends MysqlTestCase
{
    public function testCot()
    {
        $q = $this->entityManager->createQuery("SELECT COT(2) from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT COT(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
