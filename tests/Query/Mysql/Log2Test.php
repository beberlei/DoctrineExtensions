<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

class Log2Test extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testLog2(): void
    {
        $this->assertDqlProducesSql(
            "SELECT LOG2(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT LOG2(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
