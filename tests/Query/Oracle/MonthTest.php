<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

class MonthTest extends OracleTestCase
{
    public function testMonth(): void
    {
        $this->assertDqlProducesSql(
            'SELECT MONTH(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(MONTH FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
