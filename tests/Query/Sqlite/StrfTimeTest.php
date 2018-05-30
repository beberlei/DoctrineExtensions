<?php

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

class StrfTimeTest extends SqliteTestCase
{
    public function getFunctionFormatters()
    {
        return array(
            array('Year', '%Y'),
            array('Weekday', '%w'),
            array('Month', '%m'),
            array('Minute', '%M'),
            array('Hour', '%H'),
            array('Day', '%d'),
            array('Date', '%Y-%m-%d')
        );
    }

    /**
     * @dataProvider getFunctionFormatters
     */
    public function testStrfTimes($function, $formatter)
    {
        $this->assertDqlProducesSql(
            sprintf('SELECT %s(p.created) as Year FROM DoctrineExtensions\Tests\Entities\Date p', $function),
            sprintf("SELECT strftime('%s', d0_.created) AS %s FROM Date d0_", $formatter, $this->columnAlias)
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
