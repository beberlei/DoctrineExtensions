<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

final class ExpTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testExp()
    {
        $this->assertDqlProducesSql(
            "SELECT EXP(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT EXP(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
