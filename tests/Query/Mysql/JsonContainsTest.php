<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonContainsTest extends MysqlTestCase
{
    public function testJsonContainsWithoutPath(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS('{}', :param) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_CONTAINS('{}', ?) AS sclr_0 FROM Blank b0_",
            ['param' => '']
        );
    }

    public function testJsonContainsWithPathAsParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS('{}', :param, :path) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_CONTAINS('{}', ?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonContainsWithPathAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS('{}', :param, '$[0]') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_CONTAINS('{}', ?, '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
