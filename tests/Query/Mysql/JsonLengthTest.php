<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonLengthTest extends MysqlTestCase
{
    public function testJsonLengthWithoutPath(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('{}') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_LENGTH('{}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonLengthWithPathAsParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('{}', :param) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_LENGTH('{}', ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonLengthWithPathAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('{}', '$[0]') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_LENGTH('{}', '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
