<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SubstringIndexTest extends MysqlTestCase
{
    public function testSubstringIndex()
    {
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING_INDEX(2, 3, 4) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT SUBSTRING_INDEX(2, 3, 4) AS sclr_0 FROM Blank b0_'
        );
    }
}
