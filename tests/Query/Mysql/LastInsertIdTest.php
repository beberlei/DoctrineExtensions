<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LastInsertIdTest extends MysqlTestCase
{
    public function testLastInsertId()
    {
        $this->assertDqlProducesSql(
            'SELECT LAST_INSERT_ID() from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAST_INSERT_ID() AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LAST_INSERT_ID(b.id + 10) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAST_INSERT_ID((b0_.id + 10)) AS sclr_0 FROM Blank b0_'
        );
    }
}
