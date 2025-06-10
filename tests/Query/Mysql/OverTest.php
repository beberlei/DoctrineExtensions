<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class OverTest extends MysqlTestCase
{
    public function testPartitionBy(): void
    {
        $this->assertDqlProducesSql(
            'SELECT OVER(LEAD(COUNT(b.id)), PARTITION BY b.id ORDER BY b.id DESC) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id)) OVER (PARTITION BY b0_.id ORDER BY b0_.id DESC) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT OVER(LEAD(COUNT(b.id)), PARTITION BY COUNT(b.id) ORDER BY COUNT(b.id) DESC) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAD(COUNT(b0_.id)) OVER (PARTITION BY COUNT(b0_.id) ORDER BY COUNT(b0_.id) DESC) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testLead(): void
    {
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

    public function testLag(): void
    {
        $this->assertDqlProducesSql(
            'SELECT OVER(LAG(COUNT(b.id)), ORDER BY b.id) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAG(COUNT(b0_.id)) OVER (ORDER BY b0_.id ASC) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT OVER(LAG(COUNT(b.id))) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAG(COUNT(b0_.id)) OVER () AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT OVER(COUNT(b.id) - LAG(COUNT(b.id)), ORDER BY b.id) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT COUNT(b0_.id) - LAG(COUNT(b0_.id)) OVER (ORDER BY b0_.id ASC) AS sclr_0 FROM Blank b0_'
        );
    }
}
