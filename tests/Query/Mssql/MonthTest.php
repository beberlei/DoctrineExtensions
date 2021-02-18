<?php

namespace DoctrineExtensions\Tests\Query\Mssql;

use DoctrineExtensions\Tests\Query\MssqlTestCase;

class MonthTest extends MssqlTestCase
{
    public function testMonth()
    {
        $this->assertDqlProducesSql(
            "SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT MONTH(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
