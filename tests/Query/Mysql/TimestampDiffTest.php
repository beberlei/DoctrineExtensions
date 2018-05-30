<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimestampDiffTest extends MysqlTestCase
{
    public function testTimestampDiff()
    {
        $q = $this->entityManager->createQuery("SELECT TIMESTAMPDIFF(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT TIMESTAMPDIFF(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
