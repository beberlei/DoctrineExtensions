<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class JsonDepthTest extends MysqlTestCase
{
    public function testJsonDepthWithTargetExplicit(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DEPTH('{}') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT JSON_DEPTH('{}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonDepthWithTargetParam(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DEPTH(:param) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT JSON_DEPTH(?) AS sclr_0 FROM Blank b0_'
        );
    }
}
