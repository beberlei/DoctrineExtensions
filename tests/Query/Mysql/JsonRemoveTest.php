<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonRemoveTest extends MysqlTestCase
{
    public function testJsonRemoveWithPathAsParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('{}', :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_REMOVE('{}', ?) AS sclr_0 FROM Blank b0_",
            ['path' => '$[0]']
        );
    }

    public function testJsonRemoveWithPathAsNoParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('{}', :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_REMOVE('{}', ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonRemoveWithPathAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('{}', '$[0]') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_REMOVE('{}', '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
