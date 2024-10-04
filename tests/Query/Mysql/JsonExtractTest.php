<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonExtractTest extends MysqlTestCase
{
    public function testJsonExtract(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{\"key\": \"value\"}', '$.key') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{\"key\": \"value\"}', '$.key') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonExtractWithParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT(:json, :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT(?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonExtractWithNestedPath(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{\"outer\": {\"inner\": \"value\"}}', '$.outer.inner') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{\"outer\": {\"inner\": \"value\"}}', '$.outer.inner') AS sclr_0 FROM Blank b0_"
        );
    }
}