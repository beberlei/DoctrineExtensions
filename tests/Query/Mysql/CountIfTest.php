<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CountIfTest extends MysqlTestCase
{
    public function testCountIf()
    {
        $this->assertDqlProducesSql(
            "SELECT COUNTIF(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT COUNT(CASE 2 WHEN 3 THEN 1 ELSE NULL END) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testCountIfInverse()
    {
        $this->assertDqlProducesSql(
            "SELECT COUNTIF(2, 3 INVERSE) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT COUNT(CASE 2 WHEN 3 THEN NULL ELSE 1 END) AS sclr_0 FROM Blank b0_'
        );
    }
}
