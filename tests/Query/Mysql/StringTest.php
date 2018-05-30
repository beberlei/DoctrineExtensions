<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class StringTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testAscii()
    {
        $this->assertDqlProducesSql(
            "SELECT ASCII('A') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT ASCII('A') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * Not implemented
     *
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testCharLength()
    {
        $this->assertDqlProducesSql(
            "SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testConcatWithSeparator()
    {
        $this->assertDqlProducesSql(
            "SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * Not implemented
     *
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testConcatWithSeparatorWithNull()
    {
        $this->assertDqlProducesSql(
            "SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testField()
    {
        $this->assertDqlProducesSql(
            "SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testReplace()
    {
        $this->assertDqlProducesSql(
            "SELECT REPLACE('www.mysql.com', 'w', 'Ww') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT REPLACE('www.mysql.com', 'w', 'Ww') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testSoundex()
    {
        $this->assertDqlProducesSql(
            "SELECT SOUNDEX('Hello') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SOUNDEX('Hello') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * Test cases for MYSQL SUBSTRING function.
     */
    public function testSubstring()
    {
        $this->assertDqlProducesSql(
            "SELECT SUBSTRING('www.mysql.com', 1, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTR('www.mysql.com', 1, 3) AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT SUBSTRING('www.mysql.com', 2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTR('www.mysql.com', 2, LENGTH('www.mysql.com')) AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT SUBSTRING('www.mysql.com', -2, 2) from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT SUBSTR('www.mysql.com', -2, 2) AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT SUBSTRING(b.id, 5, 5) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT SUBSTR(b0_.id, 5, 5) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            "SELECT SUBSTRING(b.id, 5) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT SUBSTR(b0_.id, 5, LENGTH(b0_.id)) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            "SELECT SUBSTRING(b.id, -5, 2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT SUBSTR(b0_.id, -5, 2) AS sclr_0 FROM Blank b0_'
        );
    }

    /**
     * Test cases for MYSQL SUBSTRING_INDEX function.
     */
    public function testSubstringIndex()
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

    public function testLeast()
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

    public function testGreatest()
    {
        $this->assertDqlProducesSql(
            "SELECT GREATEST(10,1,4,0.4,0.003) AS great FROM DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT GREATEST(10, 1, 4, 0.4, 0.003) AS sclr_0 FROM Blank b0_'
        );

        $this->assertDqlProducesSql(
            "SELECT GREATEST('M', 'N', 'o', 'c', 'C') AS great FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT GREATEST('M', 'N', 'o', 'c', 'C') AS sclr_0 FROM Blank b0_"
        );
        $this->assertDqlProducesSql(
            "SELECT GREATEST(b.id, 15) AS great FROM DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT GREATEST(b0_.id, 15) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testLpad()
    {
        $this->assertDqlProducesSql(
            "SELECT LPAD('Hellow', 10, '**') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT LPAD('Hellow', 10, '**') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testRpad()
    {
        $this->assertDqlProducesSql(
            "SELECT RPAD('Hellow', 10, '**') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT RPAD('Hellow', 10, '**') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testInstr()
    {
        $this->assertDqlProducesSql(
            "SELECT INSTR('www.mysql.com', 'mysql') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT INSTR('www.mysql.com', 'mysql') AS sclr_0 FROM Blank b0_"
        );
    }
}
