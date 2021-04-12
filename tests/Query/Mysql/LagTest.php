<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class LagTest extends MysqlTestCase
{
    public function testLag(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LAG(COUNT(b.id)) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAG(COUNT(b0_.id)) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LAG(COUNT(b.id), 5) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAG(COUNT(b0_.id), 5) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LAG(COUNT(b.id), 5, 10) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAG(COUNT(b0_.id), 5, 10) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT LAG(COUNT(b.id), 5, 5 + 5) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LAG(COUNT(b0_.id), 5, 5 + 5) AS sclr_0 FROM Blank b0_'
        );

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
