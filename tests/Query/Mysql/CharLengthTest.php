<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CharLengthTest extends MysqlTestCase
{
    public function testCharLength()
    {
        $q = $this->entityManager->createQuery("SELECT CHAR_LENGTH(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CHAR_LENGTH(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
