<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class UtcTimestampTest extends MysqlTestCase
{
    public function testUtcTimestamp(): void
    {
        $dql = 'SELECT d FROM DoctrineExtensions\Tests\Entities\Date d WHERE d.created > utc_timestamp()';
        $this->assertDqlProducesSql(
            $dql,
            'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE d0_.created > UTC_TIMESTAMP()'
        );
    }
}
