<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class StringTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    /**
     * Not implemented
     *
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testCharLength()
    {
        $q = $this->entityManager->createQuery("SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CHAR_LENGTH(CHAR(0x65)), CHAR_LENGTH(CHAR(0x65 USING utf8)) AS sclr0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testConcatWithSeparator()
    {
        $q = $this->entityManager->createQuery("SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT CONCAT_WS(',', 'First name', 'Second name', 'Last Name') AS sclr0 FROM Blank b0_",
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
            "SELECT CONCAT_WS(',', 'First name', NULL, 'Last Name') AS sclr0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testField()
    {
        $q = $this->entityManager->createQuery("SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT FIELD('ej', 'Hej', 'ej', 'Heja', 'hej', 'foo') AS sclr0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testReplace()
    {
        $q = $this->entityManager->createQuery("SELECT REPLACE('www.mysql.com', 'w', 'Ww') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT REPLACE('www.mysql.com', 'w', 'Ww') AS sclr0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testSoundex()
    {
        $q = $this->entityManager->createQuery("SELECT SOUNDEX('Hello') from DoctrineExtensions\Tests\Entities\Blank");

        $this->assertEquals(
            "SELECT SOUNDEX('Hello') AS sclr0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
