<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class Md5Test extends MysqlTestCase
{
    public function testMd5()
    {
        $this->assertDqlProducesSql(
            "SELECT MD5('2') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT MD5('2') AS sclr_0 FROM Blank b0_"
        );
    }
}
