<?php
/**
 * User: tarjei
 * Date: 23.06.15 / 12:23
 */

namespace DoctrineExtensions\Tests\Query\Sqlite;

use DoctrineExtensions\Tests\Query\SqliteTestCase;

/**
 * Class FunctionsTest
 * @package DoctrineExtensions\Tests\Query\Sqlite
 */
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

        $dql = sprintf(
            'SELECT %s(p.created) as Year FROM DoctrineExtensions\Tests\Entities\Date p',
            $function
        );
        $q = $this->entityManager->createQuery($dql);
        $this->assertEquals(
            sprintf(
                "SELECT strftime('%s', d0_.created) AS %s FROM Date d0_",
                $formatter, $this->columnAlias
            ),
            $q->getSql()
        );

    }

    /**
     */
    public function testStrfTime()
    {

        $dql = 'SELECT StrfTime(\'%s\', p.created) as Time FROM DoctrineExtensions\Tests\Entities\Date p';
        $q = $this->entityManager->createQuery($dql);
        $this->assertEquals(
            "SELECT strftime('%s', d0_.created) AS {$this->columnAlias} FROM Date d0_",
            $q->getSql()
        );

    }

}
