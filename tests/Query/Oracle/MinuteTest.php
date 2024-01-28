<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Oracle;

class MinuteTest extends \DoctrineExtensions\Tests\Query\OracleTestCase
{
    public function testMinute()
    {
        $this->assertDqlProducesSql(
            "SELECT MINUTE(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
