<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class StringTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function testAscii()
    {
        $q = $this->entityManager->createQuery("SELECT ASCII('A') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT ASCII('A') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    /**
     * Not implemented
     *
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testCharLength()
    {
        $q = $this->entityManager->createQuery("SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testConcatWithSeparator()
    {
        $q = $this->entityManager->createQuery("SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    /**
     * Not implemented
     *
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testConcatWithSeparatorWithNull()
    {
        $q = $this->entityManager->createQuery("SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testField()
    {
        $q = $this->entityManager->createQuery("SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testReplace()
    {
        $q = $this->entityManager->createQuery("SELECT REPLACE('www.mysql.com', 'w', 'Ww') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT REPLACE('www.mysql.com', 'w', 'Ww') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testSoundex()
    {
        $q = $this->entityManager->createQuery("SELECT SOUNDEX('Hello') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SOUNDEX('Hello') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

  /**
   * Test cases for MYSQL SUBSTRING_INDEX function.
   */
    public function testSubstringIndex()
    {
      $q = $this->entityManager->createQuery("SELECT SUBSTRING_INDEX('www.mysql.com', '.', 2) from DoctrineExtensions\Tests\Entities\Blank");
      $this->assertEquals("SELECT SUBSTRING_INDEX('www.mysql.com', '.', 2) AS sclr_0 FROM Blank b0_", $q->getSql());
      $q = $this->entityManager->createQuery("SELECT SUBSTRING_INDEX('www.mysql.com', '.', -2) from DoctrineExtensions\Tests\Entities\Blank");
      $this->assertEquals("SELECT SUBSTRING_INDEX('www.mysql.com', '.', -2) AS sclr_0 FROM Blank b0_", $q->getSql());
      $q = $this->entityManager->createQuery("SELECT SUBSTRING_INDEX('www.mysql.com', '.', '-2') from DoctrineExtensions\Tests\Entities\Blank");
      $this->assertEquals("SELECT SUBSTRING_INDEX('www.mysql.com', '.', '-2') AS sclr_0 FROM Blank b0_", $q->getSql());
      $q = $this->entityManager->createQuery("SELECT SUBSTRING_INDEX(b.id, '', '4') from DoctrineExtensions\Tests\Entities\Blank b");
      $this->assertEquals("SELECT SUBSTRING_INDEX(b0_.id, '', '4') AS sclr_0 FROM Blank b0_", $q->getSql());
      $q = $this->entityManager->createQuery("SELECT SUBSTRING_INDEX(b.id, '', -1) from DoctrineExtensions\Tests\Entities\Blank b");
      $this->assertEquals("SELECT SUBSTRING_INDEX(b0_.id, '', -1) AS sclr_0 FROM Blank b0_", $q->getSql());
    }

    /**
     * Test case for MYSQL Comparison function LEAST.
     */
    public function testLeast()
    {
        $q = $this->entityManager->createQuery("SELECT LEAST(10,1,-4,0.4,0.003) AS lest FROM DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            'SELECT LEAST(10, 1, -4, 0.4, 0.003) AS sclr_0 FROM Blank b0_',
            $q->getSql()
        );

        $q = $this->entityManager->createQuery("SELECT LEAST('M', 'N', 'o', 'c', 'C') AS lest FROM DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT LEAST('M', 'N', 'o', 'c', 'C') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );

        $q = $this->entityManager->createQuery("SELECT LEAST(b.id, 15) AS lest FROM DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT LEAST(b0_.id, 15) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    /**
     * Test case for MYSQL Comparison function GREATEST.
     */
    public function testGreatest()
    {
        $q = $this->entityManager->createQuery("SELECT GREATEST(10,1,4,0.4,0.003) AS great FROM DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            'SELECT GREATEST(10, 1, 4, 0.4, 0.003) AS sclr_0 FROM Blank b0_',
            $q->getSql()
        );

        $q = $this->entityManager->createQuery("SELECT GREATEST('M', 'N', 'o', 'c', 'C') AS great FROM DoctrineExtensions\Tests\Entities\Blank b");

        $this->assertEquals(
            "SELECT GREATEST('M', 'N', 'o', 'c', 'C') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );

        $q = $this->entityManager->createQuery("SELECT GREATEST(b.id, 15) AS great FROM DoctrineExtensions\Tests\Entities\Blank b");
        $this->assertEquals(
            "SELECT GREATEST(b0_.id, 15) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    /**
     * Test case for MYSQL function LPAD.
     */
    public function testLpad()
    {
        $q = $this->entityManager->createQuery("SELECT LPAD('Hellow', 10, '**') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT LPAD('Hellow', 10, '**') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    /**
     * Test case for MYSQL function RPAD.
     */
    public function testRpad()
    {
        $q = $this->entityManager->createQuery("SELECT RPAD('Hellow', 10, '**') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT RPAD('Hellow', 10, '**') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

  /**
   * Test cases for MYSQL INSTR function.
   */
  public function testInstr()
  {
    $q = $this->entityManager->createQuery("SELECT INSTR('www.mysql.com', 'mysql') from DoctrineExtensions\Tests\Entities\Blank");
    $this->assertEquals("SELECT INSTR('www.mysql.com', 'mysql') AS sclr_0 FROM Blank b0_", $q->getSql());
  }

}
