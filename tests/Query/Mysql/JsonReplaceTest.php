<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonReplaceTest extends MysqlTestCase
{
    public function testJsonReplaceWithPathValue(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{}', :path, :value) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_REPLACE('{}', ?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonReplaceWithManyPathValue(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{}', :path1, :value1, :path2, :value2) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_REPLACE('{}', ?, ?, ?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonReplaceAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{}', '$[0]', '0') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_REPLACE('{}', '$[0]', '0') AS sclr_0 FROM Blank b0_"
        );
    }
}
