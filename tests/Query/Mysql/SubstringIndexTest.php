<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SubstringIndexTest extends MysqlTestCase
{
    public function testSubstringIndex()
    {
        $q = $this->entityManager->createQuery("SELECT SUBSTRING_INDEX(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SUBSTRING_INDEX(2, 3, 4) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
