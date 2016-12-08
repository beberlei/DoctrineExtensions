<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class FromUnixTimeTest extends MysqlTestCase
{
    public function testFromUnixTime()
    {
        $q = $this->entityManager->createQuery("SELECT FROM_UNIXTIME(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT FROM_UNIXTIME(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
