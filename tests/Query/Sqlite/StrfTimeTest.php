<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class StrfTimeTest extends SqliteTestCase
{
    public function getFunctionFormatters()
    {
        return [
            ['Year', '%Y'],
            ['Month', '%m'],
            ['Week', '%W'],
            ['Weekday', '%w'],
            ['Day', '%d'],
            ['Hour', '%H'],
            ['Minute', '%M'],
            ['Second', '%S'],
        ];
    }

    /**
     * @dataProvider getFunctionFormatters
     */
    public function testStrfTimes($function, $formatter)
    {
        $this->assertDqlProducesSql(
            sprintf('SELECT %s(p.created) as Year FROM DoctrineExtensions\Tests\Entities\Date p', $function),
            sprintf("SELECT CAST(STRFTIME('%s', d0_.created) AS NUMBER) AS %s FROM Date d0_", $formatter, $this->columnAlias)
        );
    }

    public function testStrfTime()
    {
        $this->assertDqlProducesSql(
            'SELECT StrfTime(\'%s\', p.created) as Time FROM DoctrineExtensions\Tests\Entities\Date p',
            "SELECT strftime('%s', d0_.created) AS {$this->columnAlias} FROM Date d0_"
        );
    }
}
