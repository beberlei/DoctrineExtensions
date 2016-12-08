<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RegexpTest extends MysqlTestCase
{
    public function testRegexp()
    {
        $q = $this->entityManager->createQuery("SELECT REGEXP('2', '3') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ('2' REGEXP '3') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
