<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimeDiffTest extends MysqlTestCase
{
    public function testTimeDiff()
    {
        $q = $this->entityManager->createQuery("SELECT TIMEDIFF(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT TIMEDIFF(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
