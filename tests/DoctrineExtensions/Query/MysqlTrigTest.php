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
        $config->addCustomNumericFunction('ATAN', 'DoctrineExtensions\Query\Mysql\Atan');
        $config->addCustomNumericFunction('ATAN2', 'DoctrineExtensions\Query\Mysql\Atan2');

        $config->addCustomNumericFunction('DEGREES', 'DoctrineExtensions\Query\Mysql\Degrees');
        $config->addCustomNumericFunction('RADIANS', 'DoctrineExtensions\Query\Mysql\Radians');

        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

    }

    public function testSin()
    {

    	$this->_assertFirstQuery('SIN');

    	$this->_assertSecondQuery('SIN');

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

    	$dql = "SELECT ATAN(p.latitude, p.longitude) FROM Entities\BlogPost p ";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT ATAN(b0_.latitude, b0_.longitude) AS sclr0 FROM BlogPost b0_";
        $this->assertEquals($sql, $q->getSql());

    }

    public function testAtan2()
    {

    	$dql = "SELECT ATAN2(p.latitude, p.longitude) FROM Entities\BlogPost p ";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT ATAN2(b0_.latitude, b0_.longitude) AS sclr0 FROM BlogPost b0_";
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

    	$dql = "SELECT p FROM Entities\BlogPost p "
    		. "WHERE " . $func . "(p.latitude) = 1";

        return $this->entityManager->createQuery($dql);

    }

    protected function _getFirstSqlQuery($func)
    {

    	return "SELECT b0_.id AS id0, b0_.created AS created1, "
    		. "b0_.longitude AS longitude2, b0_.latitude AS latitude3 "
    		. "FROM BlogPost b0_ WHERE " . $func . "(b0_.latitude) = 1";

    }

	protected function _getSecondDqlQuery($func)
	{

        $dql = "SELECT " . $func . "(p.latitude) FROM Entities\BlogPost p";
        return $this->entityManager->createQuery($dql);

	}

	protected function _getSecondSqlQuery($func)
	{

        return "SELECT " . $func . "(b0_.latitude) AS sclr0 FROM BlogPost b0_";

	}

}
