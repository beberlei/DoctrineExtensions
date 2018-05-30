<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimestampAddTest extends MysqlTestCase
{
    public function testTimestampAdd()
    {
        $q = $this->entityManager->createQuery("SELECT TIMESTAMPADD(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT TIMESTAMPADD(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
