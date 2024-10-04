<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RegexpSubStrTest extends MysqlTestCase
{
    public function testRegexpSubStr()
    {
        $this->assertDqlProducesSql(
            "SELECT REGEXP_SUBSTR('abc def ghi', '[a-z]+') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT REGEXP_SUBSTR('abc def ghi', '[a-z]+') AS sclr_0 FROM Blank b0_"
        );
    }
}
