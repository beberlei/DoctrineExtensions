<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonInsertTest extends MysqlTestCase
{
    public function testJsonInsertWithPathValue(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{}', :path, :value) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_INSERT('{}', ?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonInsertWithManyPathValue(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{}', :path1, :value1, :path2, :value2) from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_INSERT('{}', ?, ?, ?, ?) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonInsertAsExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{}', '$[0]', '0') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT JSON_INSERT('{}', '$[0]', '0') AS sclr_0 FROM Blank b0_"
        );
    }
}
