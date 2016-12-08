<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DateDiffTest extends MysqlTestCase
{
    public function testDateDiff()
    {
        $q = $this->entityManager->createQuery("SELECT DATEDIFF(5, 2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DATEDIFF(5, 2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
