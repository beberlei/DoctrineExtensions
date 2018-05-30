<?php

namespace beberlei\DoctrineExtensions\tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class VarianceTest extends MysqlTestCase
{
    public function testVariance()
    {
        $this->assertDqlProducesSql(
            "SELECT VARIANCE(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT VARIANCE(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
