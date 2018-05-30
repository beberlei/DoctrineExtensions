<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class MinuteTest extends MysqlTestCase
{
    public function testMinute()
    {
        $q = $this->entityManager->createQuery("SELECT MINUTE(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT MINUTE(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
