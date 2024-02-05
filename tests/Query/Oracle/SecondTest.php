<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

class SecondTest extends OracleTestCase
{
    public function testSecond(): void
    {
        $this->assertDqlProducesSql(
            'SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT FLOOR(EXTRACT(SECOND FROM 2)) AS sclr_0 FROM Blank b0_'
        );
    }
}
