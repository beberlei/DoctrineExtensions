<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use Doctrine\ORM\Query\QueryException;
use DoctrineExtensions\Tests\Query\MysqlTestCase;

class StringTest extends MysqlTestCase
{
    public function testAscii(): void
    {
        $this->assertDqlProducesSql(
            "SELECT ASCII('A') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT ASCII('A') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * Not implemented
     */
    public function testCharLength(): void
    {
        $this->expectException(QueryException::class);

        $this->assertDqlProducesSql(
            'SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) from DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testConcatWithSeparator(): void
    {
        $this->assertDqlProducesSql(
            "SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * Not implemented
     */
    public function testConcatWithSeparatorWithNull(): void
    {
        $this->expectException(QueryException::class);

        $this->assertDqlProducesSql(
            "SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testField(): void
    {
        $this->assertDqlProducesSql(
            "SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testReplace(): void
    {
        $this->assertDqlProducesSql(
            "SELECT REPLACE('www.mysql.com', 'w', 'Ww') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT REPLACE('www.mysql.com', 'w', 'Ww') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testSoundex(): void
    {
        $this->assertDqlProducesSql(
            "SELECT SOUNDEX('Hello') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SOUNDEX('Hello') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * Test cases for MYSQL SUBSTRING_INDEX function.
     */
    public function testSubstringIndex(): void
    {
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING_INDEX('www.mysql.com', '.', 2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTRING_INDEX('www.mysql.com', '.', 2) AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING_INDEX('www.mysql.com', '.', -2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTRING_INDEX('www.mysql.com', '.', -2) AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING_INDEX('www.mysql.com', '.', '-2') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTRING_INDEX('www.mysql.com', '.', '-2') AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING_INDEX(b.id, '', '4') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTRING_INDEX(b0_.id, '', '4') AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING_INDEX(b.id, '', -1) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTRING_INDEX(b0_.id, '', -1) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testLeast(): void
    {
        $this->assertDqlProducesSql(
            'SELECT LEAST(10,1,-4,0.4,0.003) AS lest FROM DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAST(10, 1, -4, 0.4, 0.003) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            "SELECT LEAST('M', 'N', 'o', 'c', 'C') AS lest FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT LEAST('M', 'N', 'o', 'c', 'C') AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            'SELECT LEAST(b.id, 15) AS lest FROM DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT LEAST(b0_.id, 15) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testGreatest(): void
    {
        $this->assertDqlProducesSql(
            'SELECT GREATEST(10,1,4,0.4,0.003) AS great FROM DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT GREATEST(10, 1, 4, 0.4, 0.003) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            "SELECT GREATEST('M', 'N', 'o', 'c', 'C') AS great FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT GREATEST('M', 'N', 'o', 'c', 'C') AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            'SELECT GREATEST(b.id, 15) AS great FROM DoctrineExtensions\Tests\Entities\Blank b',
            'SELECT GREATEST(b0_.id, 15) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testLpad(): void
    {
        $this->assertDqlProducesSql(
            "SELECT LPAD('Hellow', 10, '**') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT LPAD('Hellow', 10, '**') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testRpad(): void
    {
        $this->assertDqlProducesSql(
            "SELECT RPAD('Hellow', 10, '**') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT RPAD('Hellow', 10, '**') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testInstr(): void
    {
        $this->assertDqlProducesSql(
            "SELECT INSTR('www.mysql.com', 'mysql') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT INSTR('www.mysql.com', 'mysql') AS sclr_0 FROM Blank b0_"
        );
    }
}
