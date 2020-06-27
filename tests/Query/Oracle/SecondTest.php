<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

class SecondTest extends \DoctrineExtensions\Tests\Query\OracleTestCase
{
    public function testSecond()
    {
        $this->assertDqlProducesSql(
            "SELECT SECOND(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FLOOR(EXTRACT(SECOND FROM 2)) AS sclr_0 FROM Blank b0_'
        );
    }
}
