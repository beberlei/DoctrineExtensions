<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Log10Test extends MysqlTestCase
{
    public function testLog10()
    {
        $q = $this->entityManager->createQuery("SELECT LOG10(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT LOG10(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
