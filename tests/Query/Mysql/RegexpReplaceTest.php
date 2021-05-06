<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class RegexpReplaceTest extends MysqlTestCase
{
    public function testRegexp()
    {
        $this->assertDqlProducesSql(
            "SELECT REGEXP_REPLACE(b.id, '[^a-zA-Z]', '') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT REGEXP_REPLACE(b0_.id, '[^a-zA-Z]', '') AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT REGEXP_REPLACE(LOWER(b.id), '[^a-zA-Z]', '') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT REGEXP_REPLACE(LOWER(b0_.id), '[^a-zA-Z]', '') AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT REGEXP_REPLACE((SELECT c.id from DoctrineExtensions\Tests\Entities\Blank c), '[^a-zA-Z]', '') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT REGEXP_REPLACE(SELECT b0_.id FROM Blank b0_, '[^a-zA-Z]', '') AS sclr_0 FROM Blank b1_"
        );
    }
}
