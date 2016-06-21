<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class StdDevTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testStdDev()
    {
        $q = $this->entityManager->createQuery("SELECT STDDEV(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT STDDEV(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
