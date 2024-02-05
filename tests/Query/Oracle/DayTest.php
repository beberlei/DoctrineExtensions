<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

class DayTest extends OracleTestCase
{
    public function testDay(): void
    {
        $this->assertDqlProducesSql(
            'SELECT DAY(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(DAY FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
