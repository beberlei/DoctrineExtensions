<?php

namespace DoctrineExtensions\Tests\Query\Oracle;

use DoctrineExtensions\Tests\Query\OracleTestCase;

class MinuteTest extends OracleTestCase
{
    public function testMinute(): void
    {
        $this->assertDqlProducesSql(
            'SELECT MINUTE(2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
