<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

use function date;

class DateTest extends MysqlTestCase
{
    public function testDateDiff(): void
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEDIFF(CURRENT_TIME(), p.created) < 7';
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATEDIFF(CURRENT_TIME, d0_.created) < 7';

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testDateAdd(): void
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), 4, 'MONTH') < 7";
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL 4 MONTH) < 7';

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testDateAddWithColumnAlias(): void
    {
        $dql = "SELECT p.created as alternative FROM DoctrineExtensions\Tests\Entities\Date p HAVING DATEADD(alternative, 4, 'MONTH') < 7";
        $sql = 'SELECT d0_.created AS created_0 FROM Date d0_ HAVING DATE_ADD(created_0, INTERVAL 4 MONTH) < 7';

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testDateAddWithNegative(): void
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATEADD(CURRENT_TIME(), -4, 'MONTH') < 7";
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL -4 MONTH) < 7';

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testDateSub(): void
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE DATESUB(CURRENT_TIME(), 4, 'MONTH') < 7";
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE DATE_SUB(CURRENT_TIME, INTERVAL 4 MONTH) < 7';

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testExtract(): void
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE 201702 > EXTRACT(YEAR_MONTH FROM p.created)';
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE 201702 > EXTRACT(YEAR_MONTH FROM d0_.created)';

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testFromUnixtime(): void
    {
        $dql = "SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE FROM_UNIXTIME(CURRENT_TIME()) = '2000-01-01 00:00:00'";
        $sql = "SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE FROM_UNIXTIME(CURRENT_TIME) = '2000-01-01 00:00:00'";

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testPeriodDiff(): void
    {
        $dql = "SELECT PERIOD_DIFF(date_format(p.created, '%Y%m'), date_format(p.created, '%Y%m')) FROM DoctrineExtensions\Tests\Entities\Date p";
        $sql = "SELECT PERIOD_DIFF(DATE_FORMAT(d0_.created, '%Y%m'), DATE_FORMAT(d0_.created, '%Y%m')) AS sclr_0 FROM Date d0_";

        $this->assertDqlProducesSql($dql, $sql);
    }

    public function testStrToDate(): void
    {
        $dql = 'SELECT p FROM DoctrineExtensions\Tests\Entities\Date p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime';
        $sql = 'SELECT d0_.id AS id_0, d0_.created AS created_1 FROM Date d0_ WHERE STR_TO_DATE(d0_.created, ?) < ?';

        $this->assertDqlProducesSql($dql, $sql, [
            'dateFormat' => '%Y-%m-%d %h:%i %p',
            'currentTime' => date('Y-m-d H:i:s'),
        ]);
    }

    public function testUnixTimpestamp(): void
    {
        $dql = 'SELECT UNIX_TIMESTAMP(p.created) FROM DoctrineExtensions\Tests\Entities\Date p';
        $sql = 'SELECT UNIX_TIMESTAMP(d0_.created) AS sclr_0 FROM Date d0_';

        $this->assertDqlProducesSql($dql, $sql);
    }
}
