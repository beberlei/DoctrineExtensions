<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class LogTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testLog()
    {
        $q = $this->entityManager->createQuery("SELECT LOG(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT LOG(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
