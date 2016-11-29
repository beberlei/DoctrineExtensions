<?php
namespace beberlei\DoctrineExtensions\tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class VarianceTest extends MysqlTestCase
{
    public function testVariance()
    {
        $q = $this->entityManager->createQuery("SELECT VARIANCE(2) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT VARIANCE(2) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}

