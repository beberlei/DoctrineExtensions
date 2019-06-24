<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

class CastTest extends MysqlTestCase
{
    private $entityLong = 'DoctrineExtensions\\Tests\\Entities\\BlogPost';

    private $entityShort = 'BlogPost';

    public function testSimpleSqlQuery()
    {
        $query = $this->entityManager->createQuery(
            "SELECT CAST(blog.latitude AS SIGNED) FROM {$this->entityLong} blog"
        );

        static::assertEquals(
            "SELECT CAST(b0_.latitude AS SIGNED) AS sclr_0 FROM {$this->entityShort} b0_",
            $query->getSQL()
        );
    }

    public function testMultipleCastWithFieldAliasSqlQuery()
    {
        $query = $this->entityManager->createQuery(
            "SELECT CAST(blog.latitude AS UNSIGNED), CAST(blog.latitude AS SIGNED) FROM {$this->entityLong} blog"
        );

        static::assertEquals(
            "SELECT CAST(b0_.latitude AS UNSIGNED) AS sclr_0, CAST(b0_.latitude AS SIGNED) AS sclr_1 FROM {$this->entityShort} b0_",
            $query->getSQL()
        );
    }

    public function testWithParametersSqlQuery()
    {
        $query = $this->entityManager->createQuery(
            "SELECT CAST(blog.latitude AS DECIMAL(10, 2)) FROM {$this->entityLong} blog"
        );

        static::assertEquals(
            "SELECT CAST(b0_.latitude AS DECIMAL(10, 2)) AS sclr_0 FROM {$this->entityShort} b0_",
            $query->getSQL()
        );
    }
}
