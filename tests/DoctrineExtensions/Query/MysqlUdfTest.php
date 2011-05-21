<?php

namespace DoctrineExtnsions\Query;
use Doctrine\ORM\Query\Parser;

class MysqlUdfTest extends \PHPUnit_Framework_TestCase
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

        $config->addCustomNumericFunction('DATEDIFF', 'DoctrineExtensions\Query\Mysql\DateDiff');
        $config->addCustomDatetimeFunction('DATE_ADD', 'DoctrineExtensions\Query\Mysql\DateAdd');
        $config->addCustomStringFunction('STR_TO_DATE', 'DoctrineExtensions\Query\MySql\StrToDate');
        $config->addCustomStringFunction('FIND_IN_SET', 'DoctrineExtensions\Query\MySql\FindInSet');
        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

    }

    public function testDateDiff()
    {
        $dql = "SELECT p FROM Entities\BlogPost p WHERE DATEDIFF(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT b0_.id AS id0, b0_.created AS created1, b0_.longitude AS longitude2, b0_.latitude AS latitude3 FROM BlogPost b0_ WHERE DATEDIFF(CURRENT_TIME, b0_.created) < 7";
        $this->assertEquals($sql, $q->getSql());

    }

    public function testDateAdd()
    {
        $dql = "SELECT p FROM Entities\BlogPost p WHERE DATE_ADD(CURRENT_TIME(), INTERVAL 4 MONTH) < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT b0_.id AS id0, b0_.created AS created1, b0_.longitude AS longitude2, b0_.latitude AS latitude3 FROM BlogPost b0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL 4 MONTH) < 7";
        $this->assertEquals($sql, $q->getSql());

    }

    public function testDateAdd2()
    {
        $dql = "SELECT p FROM Entities\BlogPost p WHERE DATE_ADD(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);

        $this->setExpectedException('Doctrine\ORM\Query\QueryException');

        $q->getSql();

    }
	
	public function testStrToDate()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Query\BlogPost p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime";
        $q = $this->entityManager->createQuery($dql);
		$q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
		$q->setParameter('currentTime', date('Y-m-d H:i:s'));
			
        var_dump($q->getSql());
    }
    
    public function testFindInSet()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Query\BlogPost p WHERE FIND_IN_SET(p.id, p.testSet) != 0";
        $q = $this->entityManager->createQuery($dql);

        var_dump($q->getSql());
    }
}

/**
 * @Entity
 */
class BlogPost
{
    /** @Id @Column(type="string") @GeneratedValue */
    public $id;
	
	/**
     * @Column(type="String")
     */
    public $testSet;
	
    /**
     * @Column(type="DateTime")
     */
    public $created;
}