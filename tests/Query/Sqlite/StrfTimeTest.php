<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

use function sprintf;

class StrfTimeTest extends SqliteTestCase
{
    /** @return array<int, array<int, string>> */
    public function getFunctionFormatters(): array
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

    /** @dataProvider getFunctionFormatters */
    public function testStrfTimes($function, $formatter): void
    {
        $this->assertDqlProducesSql(
            sprintf('SELECT %s(p.created) as Year FROM DoctrineExtensions\Tests\Entities\Date p', $function),
            sprintf("SELECT CAST(STRFTIME('%s', d0_.created) AS NUMBER) AS %s FROM Date d0_", $formatter, $this->columnAlias)
        );
    }

    public function testStrfTime(): void
    {
        $this->assertDqlProducesSql(
            'SELECT StrfTime(\'%s\', p.created) as Time FROM DoctrineExtensions\Tests\Entities\Date p',
            'SELECT strftime(\'%s\', d0_.created) AS ' . $this->columnAlias . ' FROM Date d0_'
        );
    }
}
