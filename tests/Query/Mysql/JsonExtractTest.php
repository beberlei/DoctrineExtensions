<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonExtractTest extends MysqlTestCase
{
    public function testJsonExtractWithPathAsParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{}', :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{}', ?) AS sclr_0 FROM Blank b0_",
            ['path' => '$[0]']
        );
    }

    public function testJsonExtractWithPathAsNoParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{}', :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{}', ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonExtractWithPathAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{}', '$[0]') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{}', '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
