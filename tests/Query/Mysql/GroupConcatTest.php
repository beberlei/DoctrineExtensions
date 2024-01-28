<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class GroupConcatTest extends MysqlTestCase
{
    public function testGroupConcat(): void
    {
        $this->assertDqlProducesSql(
            'SELECT GROUP_CONCAT(blank.id) from DoctrineExtensions\Tests\Entities\Blank as blank',
            'SELECT GROUP_CONCAT(b0_.id) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testGroupConcatWithDistinct(): void
    {
        $this->assertDqlProducesSql(
            'SELECT GROUP_CONCAT(DISTINCT blank.id) from DoctrineExtensions\Tests\Entities\Blank as blank',
            'SELECT GROUP_CONCAT(DISTINCT b0_.id) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testGroupConcatWithOrderBy(): void
    {
        $this->assertDqlProducesSql(
            'SELECT GROUP_CONCAT(blank.id ORDER BY blank.id) from DoctrineExtensions\Tests\Entities\Blank as blank',
            'SELECT GROUP_CONCAT(b0_.id  ORDER BY b0_.id ASC) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testGroupConcatWithSeparator(): void
    {
        $this->assertDqlProducesSql(
            "SELECT GROUP_CONCAT(blank.id SEPARATOR ' ') from DoctrineExtensions\Tests\Entities\Blank as blank",
            "SELECT GROUP_CONCAT(b0_.id SEPARATOR ' ') AS sclr_0 FROM Blank b0_"
        );
    }
}
