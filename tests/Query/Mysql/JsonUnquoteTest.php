<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonUnquoteTest extends MysqlTestCase
{
    public function testJsonUnquoteWithValueAsParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE(:value) from DoctrineExtensions\Tests\Entities\Blank as blank",
            'SELECT JSON_UNQUOTE(?) AS sclr_0 FROM Blank b0_',
            ['value' => '"1"']
        );
    }

    public function testJsonUnquoteWithValueAsNoParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE(:value) from DoctrineExtensions\Tests\Entities\Blank as blank",
            'SELECT JSON_UNQUOTE(?) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testJsonUnquoteWithValueAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE('\"1\"') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_UNQUOTE('\"1\"') AS sclr_0 FROM Blank b0_"
        );
    }
}
