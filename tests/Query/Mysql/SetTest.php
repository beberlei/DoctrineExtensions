<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class SetTest extends MysqlTestCase
{
    public function testFindInSet(): void
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Set p WHERE FIND_IN_SET(p.id, p.set) != 0';
        $this->assertDqlProducesSql(
            $dql,
            'SELECT s0_.id AS id_0, s0_.set AS set_1 FROM Set s0_ WHERE FIND_IN_SET(s0_.id, s0_.set) <> 0'
        );
    }
}
