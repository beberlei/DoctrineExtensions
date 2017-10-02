<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class ExpTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testExp()
    {
        $q = $this->entityManager->createQuery("SELECT EXP(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT EXP(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
