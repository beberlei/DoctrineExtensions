<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonValueTest extends MysqlTestCase
{
    public function testJsonValueWithPath(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{}', :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_VALUE('{}', ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonValueWithPathAsParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{}', :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_VALUE('{}', ?) AS sclr_0 FROM Blank b0_",
            [
                'path' => '$[0]',
            ]
        );
    }

    public function testJsonValueWithPathAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{}', '$[0]') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_VALUE('{}', '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
