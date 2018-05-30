<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimestampAddTest extends MysqlTestCase
{
    public function testTimestampAdd()
    {
        $q = $this->entityManager->createQuery("SELECT TIMESTAMPADD(MINUTE, 1, '2003-01-02') from DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT TIMESTAMPADD(MINUTE, 1, '2003-01-02') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
