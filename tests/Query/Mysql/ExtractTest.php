<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class ExtractTest extends MysqlTestCase
{
    public function testExtract(): void
    {
        $this->assertDqlProducesSql(
            'SELECT EXTRACT(MINUTE WITH 2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT EXTRACT(MINUTE AS 2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT EXTRACT(MINUTE FROM 2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            'SELECT EXTRACT(MINUTE JOIN 2) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT EXTRACT(MINUTE FROM 2) AS sclr_0 FROM Blank b0_'
        );
    }
}
