<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ConcatWsTest extends MysqlTestCase
{
    public function testConcatWs()
    {
        $q = $this->entityManager->createQuery("SELECT CONCAT_WS(',', 'TEST', 'FOO') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CONCAT_WS(',', 'TEST', 'FOO') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
