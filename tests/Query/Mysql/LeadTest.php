<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LeadTest extends MysqlTestCase
{
    public function testLag(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LEAD(COUNT(b.id)) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id)) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LEAD(COUNT(b.id), 5) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id), 5) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LEAD(COUNT(b.id), 5, 10) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id), 5, 10) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LEAD(COUNT(b.id), 5, 5 + 5) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id), 5, 5 + 5) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT OVER(LEAD(COUNT(b.id)), ORDER BY b.id) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id)) OVER (ORDER BY b0_.id ASC) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT OVER(LEAD(COUNT(b.id))) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id)) OVER () AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT OVER(COUNT(b.id) - LEAD(COUNT(b.id)), ORDER BY b.id) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT COUNT(b0_.id) - LEAD(COUNT(b0_.id)) OVER (ORDER BY b0_.id ASC) AS sclr_0 FROM Blank b0_'
        );
    }
}
