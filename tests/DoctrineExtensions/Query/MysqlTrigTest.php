<?php

namespace DoctrineExtnsions\Query;
use Doctrine\ORM\Query\Parser;

class MysqlTrigTest extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir($GLOBALS['doctrine2-proxies-path']);
        $config->setProxyNamespace($GLOBALS['doctrine2-proxies-namespace']);
        $config->setAutoGenerateProxyClasses(true);

        $driver = $config->newDefaultAnnotationDriver($GLOBALS['doctrine2-entities-path']);
        $config->setMetadataDriverImpl($driver);

        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        $config->addCustomNumericFunction('SIN', 'DoctrineExtensions\Query\Mysql\Sin');
        $config->addCustomNumericFunction('ASIN', 'DoctrineExtensions\Query\Mysql\Asin');
        $config->addCustomNumericFunction('COS', 'DoctrineExtensions\Query\Mysql\Cos');
        $config->addCustomNumericFunction('ACOS', 'DoctrineExtensions\Query\Mysql\Acos');
        $config->addCustomNumericFunction('COT', 'DoctrineExtensions\Query\Mysql\Cot');
        $config->addCustomNumericFunction('TAN', 'DoctrineExtensions\Query\Mysql\Tan');

        $config->addCustomNumericFunction('DEGREES', 'DoctrineExtensions\Query\Mysql\Degrees');
        $config->addCustomNumericFunction('RADIANS', 'DoctrineExtensions\Query\Mysql\Radians');

        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

    }

    public function testSin()
    {

        $dql = "SELECT p FROM Entities\BlogPost p WHERE SIN(p.latitude) = 1";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT b0_.id AS id0, b0_.created AS created1, b0_.longitude AS longitude2, b0_.latitude AS latitude3 FROM BlogPost b0_ WHERE SIN(b0_.latitude) = 1";
    	$this->assertEquals($sql, $q->getSql());

        $dql = "SELECT SIN(p.latitude) FROM Entities\BlogPost p";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT SIN(b0_.latitude) AS sclr0 FROM BlogPost b0_";
        $this->assertEquals($sql, $q->getSql());

    }

    public function testAsin()
    {

        $dql = "SELECT p FROM Entities\BlogPost p WHERE ASIN(p.latitude) = 1";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT b0_.id AS id0, b0_.created AS created1, b0_.longitude AS longitude2, b0_.latitude AS latitude3 FROM BlogPost b0_ WHERE ASIN(b0_.latitude) = 1";
    	$this->assertEquals($sql, $q->getSql());

        $dql = "SELECT ASIN(p.latitude) FROM Entities\BlogPost p";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT ASIN(b0_.latitude) AS sclr0 FROM BlogPost b0_";
        $this->assertEquals($sql, $q->getSql());

    }

    public function testAcos()
    {

    }

    public function testCos()
    {

    }

    public function testCot()
    {

    }

    public function testDegrees()
    {

    }

    public function testRadians()
    {

    }

    public function testTan()
    {

    }

    public function testAtan()
    {

    }

    public function testAtan2()
    {

    }

}
