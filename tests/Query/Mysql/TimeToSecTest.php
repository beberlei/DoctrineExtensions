<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimeToSecTest extends MysqlTestCase
{
    public function testTimeToSec()
    {
        $q = $this->entityManager->createQuery("SELECT TIMETOSEC(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT TIME_TO_SEC(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
