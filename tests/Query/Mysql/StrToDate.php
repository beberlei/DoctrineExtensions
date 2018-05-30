<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class StrToDate extends MysqlTestCase
{
    public function testStrToDate()
    {
        $q = $this->entityManager->createQuery("SELECT STR_TO_DATE(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT STR_TO_DATE(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
