<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonUnquoteTest extends MysqlTestCase
{
    public function testJsonUnquote(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE('{\"key\": \"value\"}') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_UNQUOTE('{\"key\": \"value\"}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonUnquoteWithParameter(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE(:param) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_UNQUOTE(?) AS sclr_0 FROM Blank b0_",
            ['param' => '{"key": "value"}']
        );
    }
}

