<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonExtractTest extends MysqlTestCase
{
    public function testJsonExtractWithSinglePath(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{}', :param) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{}', ?) AS sclr_0 FROM Blank b0_",
            ['param' => '']
        );
    }

    public function testJsonContainsWithMultiplePaths(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{}', :path1, :path2) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{}', ?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonContainsWithPathAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{}', '$[0]') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_EXTRACT('{}', '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
