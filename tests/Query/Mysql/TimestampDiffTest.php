<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class TimestampDiffTest extends MysqlTestCase
{
    public function testTimestampDiff()
    {
        $this->assertDqlProducesSql(
            "SELECT TIMESTAMPDIFF(MONTH, '2017-06-25', '2017-06-15') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT TIMESTAMPDIFF(MONTH, '2017-06-25', '2017-06-15') AS sclr_0 FROM Blank b0_"
        );
    }
}
