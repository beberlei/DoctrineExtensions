<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RoundTest extends MysqlTestCase
{
    public function testRoundOneArgument()
    {
        $q = $this->entityManager->createQuery("SELECT ROUND(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ROUND(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testRoundTwoArguments()
    {
        $q = $this->entityManager->createQuery("SELECT ROUND(2, 3) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ROUND(2, 3) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
