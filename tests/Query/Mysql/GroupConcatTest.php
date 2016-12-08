<?php
namespace Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class GroupConcatTest extends MysqlTestCase
{
    public function testGroupConcat()
    {
        $q = $this->entityManager->createQuery("SELECT GROUP_CONCAT(blank.id) from DoctrineExtensions\Tests\Entities\Blank as blank");

        $this->assertEquals(
            "SELECT GROUP_CONCAT(b0_.id) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testGroupConcatWithDistinct()
    {
        $q = $this->entityManager->createQuery("SELECT GROUP_CONCAT(DISTINCT blank.id) from DoctrineExtensions\Tests\Entities\Blank as blank");

        $this->assertEquals(
            "SELECT GROUP_CONCAT(DISTINCT b0_.id) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testGroupConcatWithOrderBy()
    {
        $q = $this->entityManager->createQuery("SELECT GROUP_CONCAT(blank.id ORDER BY blank.id) from DoctrineExtensions\Tests\Entities\Blank as blank");

        $this->assertEquals(
            "SELECT GROUP_CONCAT(b0_.id  ORDER BY b0_.id ASC) AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }

    public function testGroupConcatWithSeparator()
    {
        $q = $this->entityManager->createQuery("SELECT GROUP_CONCAT(blank.id SEPARATOR ' ') from DoctrineExtensions\Tests\Entities\Blank as blank");

        $this->assertEquals(
            "SELECT GROUP_CONCAT(b0_.id SEPARATOR ' ') AS sclr_0 FROM Blank b0_",
            $q->getSql()
        );
    }
}
