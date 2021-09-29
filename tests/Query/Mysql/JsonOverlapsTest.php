<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonOverlapsTest extends MysqlTestCase
{
    public function testJsonOverlaps(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OVERLAPS('{}', :param) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_CONTAINS('{}', ?) AS sclr_0 FROM Blank b0_",
            ['param' => '']
        );
    }
}
