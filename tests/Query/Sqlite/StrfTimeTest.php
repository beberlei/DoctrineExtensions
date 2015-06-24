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
                "SELECT strftime('%s', d0_.created) AS sclr_0 FROM Date d0_",
                $formatter
            ),
            $q->getSql()
        );

    }

    public function testYearGroupBy()
    {

        $dql = 'SELECT YEAR(p.created) as Year FROM DoctrineExtensions\Tests\Entities\Date p GROUP BY Year';
        $q = $this->entityManager->createQuery($dql);
        $this->assertEquals(
            "SELECT strftime('%Y', d0_.created) AS sclr_0 FROM Date d0_ GROUP BY sclr_0",
            $q->getSql()
        );
    }
}
