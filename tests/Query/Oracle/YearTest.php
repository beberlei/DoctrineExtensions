<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

class YearTest extends OracleTestCase
{
    public function testYear(): void
    {
        $this->assertDqlProducesSql(
            'SELECT YEAR(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(YEAR FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
