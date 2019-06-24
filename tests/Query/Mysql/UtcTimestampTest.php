<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class UtcTimestampTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testUtcTimestamp()
    {
        $dql = "SELECT d FROM DoctrineExtensions\Tests\Entities\Date d WHERE d.created > utc_timestamp()";
        $this->assertDqlProducesSql(
            $dql,
            'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE d0_.created > UTC_TIMESTAMP()'
        );
    }
}
