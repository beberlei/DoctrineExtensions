<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use Doctrine\ORM\Query;
use DoctrineExtensions\Tests\Query\MysqlTestCase;

use function deg2rad;

class TrigTest extends MysqlTestCase
{
    private $entity;

    public function setUp(): void
    {
        parent::setUp();

        $this->entity = 'DoctrineExtensions\Tests\Entities\BlogPost';
    }

    public function testSin(): void
    {
        $this->assertFirstQuery('SIN');
        $this->assertSecondQuery('SIN');

        $dql = 'SELECT SIN(RADIANS(p.latitude)) FROM ' . $this->entity . ' p';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(RADIANS(b0_.latitude)) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());

        $dql = 'SELECT SIN(p.latitude * p.longitude) FROM ' . $this->entity . ' p';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(b0_.latitude * b0_.longitude) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());

        $dql = 'SELECT SIN(RADIANS(p.latitude) * RADIANS(p.longitude)) FROM ' . $this->entity . ' p';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(RADIANS(b0_.latitude) * RADIANS(b0_.longitude)) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());

        $dql = 'SELECT p FROM ' . $this->entity . ' p WHERE p.longitude = SIN(RADIANS(p.latitude)) * RADIANS(p.longitude)';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT b0_.id AS id_0, b0_.created AS created_1, b0_.longitude AS longitude_2, b0_.latitude AS latitude_3 FROM BlogPost b0_ WHERE b0_.longitude = SIN(RADIANS(b0_.latitude)) * RADIANS(b0_.longitude)';
        $this->assertEquals($sql, $q->getSql());

        $dql = 'SELECT p FROM ' . $this->entity . ' p WHERE SIN(RADIANS(p.latitude)) * SIN(RADIANS(p.longitude)) = 1';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT b0_.id AS id_0, b0_.created AS created_1, b0_.longitude AS longitude_2, b0_.latitude AS latitude_3 FROM BlogPost b0_ WHERE SIN(RADIANS(b0_.latitude)) * SIN(RADIANS(b0_.longitude)) = 1';
        $this->assertEquals($sql, $q->getSql());

        $dql = 'SELECT SIN(RADIANS(p.latitude)) * SIN(RADIANS(p.longitude)) FROM ' . $this->entity . ' p ';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(RADIANS(b0_.latitude)) * SIN(RADIANS(b0_.longitude)) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testAsin(): void
    {
        $this->assertFirstQuery('ASIN');
        $this->assertSecondQuery('ASIN');
    }

    public function testAcos(): void
    {
        $this->assertFirstQuery('ACOS');
        $this->assertSecondQuery('ACOS');

        $dql = 'SELECT ACOS(SIN(RADIANS(p.latitude)) + SIN(RADIANS(p.longitude))) * 1 FROM ' . $this->entity . ' p';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ACOS(SIN(RADIANS(b0_.latitude)) + SIN(RADIANS(b0_.longitude))) * 1 AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testCos(): void
    {
        $this->assertFirstQuery('COS');
        $this->assertSecondQuery('COS');
    }

    public function testCot(): void
    {
        $this->assertFirstQuery('COT');
        $this->assertSecondQuery('COT');
    }

    public function testDegrees(): void
    {
        $this->assertFirstQuery('DEGREES');
        $this->assertSecondQuery('DEGREES');
    }

    public function testRadians(): void
    {
        $this->assertFirstQuery('RADIANS');
        $this->assertSecondQuery('RADIANS');
    }

    public function testTan(): void
    {
        $this->assertFirstQuery('TAN');
        $this->assertSecondQuery('TAN');
    }

    public function testAtan(): void
    {
        // test with 1 argument
        $this->assertFirstQuery('ATAN');
        $this->assertSecondQuery('ATAN');

        // test with 2 arguments
        $dql = 'SELECT ATAN(p.latitude, p.longitude) FROM ' . $this->entity . ' p ';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ATAN(b0_.latitude, b0_.longitude) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testAtan2(): void
    {
        $dql = 'SELECT ATAN2(p.latitude, p.longitude) FROM ' . $this->entity . ' p';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ATAN2(b0_.latitude, b0_.longitude) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testCosineLaw(): void
    {
        $lat           = 0.0;
        $lng           = 0.0;
        $radiusOfEarth = 6371;

        $cosineLaw = 'ACOS(SIN(' . deg2rad($lat) . ') * SIN(RADIANS(p.latitude)) '
                . '+ COS(' . deg2rad($lat) . ') * COS(RADIANS(p.latitude)) '
                . '* COS(RADIANS(p.longitude) - ' . deg2rad($lng) . ')'
                . ') * ' . $radiusOfEarth;

        $dql = 'SELECT ' . $cosineLaw . ' FROM ' . $this->entity . ' p';
        $q   = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ACOS(SIN(0) * SIN(RADIANS(b0_.latitude)) + COS(0) * COS(RADIANS(b0_.latitude)) * COS(RADIANS(b0_.longitude) - 0)) * 6371 AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    protected function assertFirstQuery($func): void
    {
        $q   = $this->getFirstDqlQuery($func);
        $sql = $this->getFirstSqlQuery($func);
        $this->assertEquals($sql, $q->getSql());
    }

    protected function assertSecondQuery($func): void
    {
        $q   = $this->getSecondDqlQuery($func);
        $sql = $this->getSecondSqlQuery($func);
        $this->assertEquals($sql, $q->getSql());
    }

    protected function getFirstDqlQuery($func): Query
    {
        $dql = 'SELECT p FROM ' . $this->entity . ' p WHERE ' . $func . '(p.latitude) = 1';

        return $this->entityManager->createQuery($dql);
    }

    protected function getFirstSqlQuery($func): string
    {
        return 'SELECT b0_.id AS id_0, b0_.created AS created_1, '
        . 'b0_.longitude AS longitude_2, b0_.latitude AS latitude_3 '
        . 'FROM BlogPost b0_ WHERE ' . $func . '(b0_.latitude) = 1';
    }

    protected function getSecondDqlQuery($func): Query
    {
        $dql = 'SELECT ' . $func . '(p.latitude) FROM ' . $this->entity . ' p';

        return $this->entityManager->createQuery($dql);
    }

    protected function getSecondSqlQuery($func): string
    {
        return 'SELECT ' . $func . '(b0_.latitude) AS sclr_0 FROM BlogPost b0_';
    }
}
