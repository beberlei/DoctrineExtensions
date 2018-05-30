<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class Atan2Test
{
    public function testAtan2()
    {
        $this->assertDqlProducesSql(
            "SELECT ATAN2(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ATAN2(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
