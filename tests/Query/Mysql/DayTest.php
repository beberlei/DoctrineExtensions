<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DayTest extends MysqlTestCase
{
    public function testDay()
    {
        $q = $this->entityManager->createQuery("SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DAY(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
