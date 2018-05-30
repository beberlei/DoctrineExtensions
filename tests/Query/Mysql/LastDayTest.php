<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LastDayTest extends MysqlTestCase
{
    public function testLastDay()
    {
        $q = $this->entityManager->createQuery("SELECT LAST_DAY(2) from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT LAST_DAY(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
