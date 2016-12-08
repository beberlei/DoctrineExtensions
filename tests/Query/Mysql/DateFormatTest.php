<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class DateFormatTest extends MysqlTestCase
{
    public function testDateFormat()
    {
        $q = $this->entityManager->createQuery("SELECT DATE_FORMAT(2, 'Y') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT DATE_FORMAT(2, 'Y') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
