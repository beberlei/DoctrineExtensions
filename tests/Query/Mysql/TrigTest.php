<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

class TrigTest extends \DoctrineExtensions\Tests\Query\MysqlTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->entity = 'DoctrineExtensions\Tests\Entities\BlogPost';
    }

    public function testSin()
    {
        $this->_assertFirstQuery('SIN');
        $this->_assertSecondQuery('SIN');

        $dql = "SELECT SIN(RADIANS(p.latitude)) FROM {$this->entity} p";
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(RADIANS(b0_.latitude)) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());

        $dql = "SELECT SIN(p.latitude * p.longitude) FROM {$this->entity} p";
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(b0_.latitude * b0_.longitude) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());

        $dql = "SELECT SIN(RADIANS(p.latitude) * RADIANS(p.longitude)) FROM {$this->entity} p";
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(RADIANS(b0_.latitude) * RADIANS(b0_.longitude)) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());

        if (\Doctrine\ORM\Version::compare('2.4.0') <= 0) {
            $dql = "SELECT p FROM {$this->entity} p WHERE p.longitude = SIN(RADIANS(p.latitude)) * RADIANS(p.longitude)";
        } else {
            $dql = "SELECT p FROM {$this->entity} p WHERE p.longitude = (SIN(RADIANS(p.latitude)) * RADIANS(p.longitude))";
        }

        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT b0_.id AS id_0, b0_.created AS created_1, b0_.longitude AS longitude_2, b0_.latitude AS latitude_3 FROM BlogPost b0_ WHERE b0_.longitude = SIN(RADIANS(b0_.latitude)) * RADIANS(b0_.longitude)';
        $this->assertEquals($sql, $q->getSql());

        $dql = "SELECT p FROM {$this->entity} p WHERE SIN(RADIANS(p.latitude)) * SIN(RADIANS(p.longitude)) = 1";
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT b0_.id AS id_0, b0_.created AS created_1, b0_.longitude AS longitude_2, b0_.latitude AS latitude_3 FROM BlogPost b0_ WHERE SIN(RADIANS(b0_.latitude)) * SIN(RADIANS(b0_.longitude)) = 1';
        $this->assertEquals($sql, $q->getSql());

        if (\Doctrine\ORM\Version::compare('2.4.0') <= 0) {
            $dql = "SELECT SIN(RADIANS(p.latitude)) * SIN(RADIANS(p.longitude)) FROM {$this->entity} p ";
        } else {
            $dql = "SELECT (SIN(RADIANS(p.latitude)) * SIN(RADIANS(p.longitude))) FROM {$this->entity} p ";
        }

        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT SIN(RADIANS(b0_.latitude)) * SIN(RADIANS(b0_.longitude)) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testAsin()
    {
        $this->_assertFirstQuery('ASIN');
        $this->_assertSecondQuery('ASIN');
    }

    public function testAcos()
    {
        $this->_assertFirstQuery('ACOS');
        $this->_assertSecondQuery('ACOS');

        if (\Doctrine\ORM\Version::compare('2.4.0') <= 0) {
            $dql = "SELECT ACOS(SIN(RADIANS(p.latitude)) + SIN(RADIANS(p.longitude))) * 1 FROM {$this->entity} p";
        } else {
            $dql = "SELECT (ACOS(SIN(RADIANS(p.latitude)) + SIN(RADIANS(p.longitude))) * 1) FROM {$this->entity} p";
        }

        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ACOS(SIN(RADIANS(b0_.latitude)) + SIN(RADIANS(b0_.longitude))) * 1 AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testCos()
    {
        $this->_assertFirstQuery('COS');
        $this->_assertSecondQuery('COS');
    }

    public function testCot()
    {
        $this->_assertFirstQuery('COT');
        $this->_assertSecondQuery('COT');
    }

    public function testDegrees()
    {
        $this->_assertFirstQuery('DEGREES');
        $this->_assertSecondQuery('DEGREES');
    }

    public function testRadians()
    {
        $this->_assertFirstQuery('RADIANS');
        $this->_assertSecondQuery('RADIANS');
    }

    public function testTan()
    {
        $this->_assertFirstQuery('TAN');
        $this->_assertSecondQuery('TAN');
    }

    public function testAtan()
    {
        // test with 1 argument
        $this->_assertFirstQuery('ATAN');
        $this->_assertSecondQuery('ATAN');

        // test with 2 arguments
        $dql = "SELECT ATAN(p.latitude, p.longitude) FROM {$this->entity} p ";
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ATAN(b0_.latitude, b0_.longitude) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testAtan2()
    {
        $dql = "SELECT ATAN2(p.latitude, p.longitude) FROM {$this->entity} p";
        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ATAN2(b0_.latitude, b0_.longitude) AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    public function testCosineLaw()
    {
        $lat = 0.0;
        $lng = 0.0;
        $radiusOfEarth = 6371;

        $cosineLaw = 'ACOS(SIN(' . deg2rad($lat) . ') * SIN(RADIANS(p.latitude)) '
                . '+ COS(' . deg2rad($lat) . ') * COS(RADIANS(p.latitude)) '
                . '* COS(RADIANS(p.longitude) - ' . deg2rad($lng) . ')'
                . ') * ' . $radiusOfEarth;

        if (\Doctrine\ORM\Version::compare('2.4.0') <= 0) {
            $dql = 'SELECT ' . $cosineLaw . " FROM {$this->entity} p";
        } else {
            $dql = 'SELECT (' . $cosineLaw . ") FROM {$this->entity} p";
        }

        $q = $this->entityManager->createQuery($dql);

        $sql = 'SELECT ACOS(SIN(0) * SIN(RADIANS(b0_.latitude)) + COS(0) * COS(RADIANS(b0_.latitude)) * COS(RADIANS(b0_.longitude) - 0)) * 6371 AS sclr_0 FROM BlogPost b0_';
        $this->assertEquals($sql, $q->getSql());
    }

    protected function _assertFirstQuery($func)
    {
        $q = $this->_getFirstDqlQuery($func);
        $sql = $this->_getFirstSqlQuery($func);
        $this->assertEquals($sql, $q->getSql());
    }

    protected function _assertSecondQuery($func)
    {
        $q = $this->_getSecondDqlQuery($func);
        $sql = $this->_getSecondSqlQuery($func);
        $this->assertEquals($sql, $q->getSql());
    }

    protected function _getFirstDqlQuery($func)
    {
        $dql = "SELECT p FROM {$this->entity} p WHERE " . $func . '(p.latitude) = 1';

        return $this->entityManager->createQuery($dql);
    }

    protected function _getFirstSqlQuery($func)
    {
        return 'SELECT b0_.id AS id_0, b0_.created AS created_1, '
        . 'b0_.longitude AS longitude_2, b0_.latitude AS latitude_3 '
        . 'FROM BlogPost b0_ WHERE ' . $func . '(b0_.latitude) = 1';
    }

    protected function _getSecondDqlQuery($func)
    {
        $dql = 'SELECT ' . $func . "(p.latitude) FROM {$this->entity} p";

        return $this->entityManager->createQuery($dql);
    }

    protected function _getSecondSqlQuery($func)
    {
        return 'SELECT ' . $func . '(b0_.latitude) AS sclr_0 FROM BlogPost b0_';
    }
}
