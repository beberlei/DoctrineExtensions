<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class Log2Test extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testLog2()
    {
        $q = $this->entityManager->createQuery("SELECT LOG2(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT LOG2(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
