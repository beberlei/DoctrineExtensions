<?php

namespace DoctrineExtensions\Query;
use Doctrine\ORM\Query\Parser;

require_once __DIR__ . '/../../Entities/BlogPost.php';

class MysqlUdfTest extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\PHPUnit\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/../../Entities'));

        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        $config->addCustomNumericFunction('DATEDIFF', 'DoctrineExtensions\Query\Mysql\DateDiff');
        $config->addCustomDatetimeFunction('DATEADD', 'DoctrineExtensions\Query\Mysql\DateAdd');
        $config->addCustomStringFunction('STR_TO_DATE', 'DoctrineExtensions\Query\Mysql\StrToDate');
        $config->addCustomStringFunction('FIND_IN_SET', 'DoctrineExtensions\Query\Mysql\FindInSet');
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
        $dql = "SELECT p FROM Entities\BlogPost p WHERE DATEADD(CURRENT_TIME(), 4, 'MONTH') < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = "SELECT b0_.id AS id0, b0_.created AS created1, b0_.longitude AS longitude2, b0_.latitude AS latitude3 FROM BlogPost b0_ WHERE DATE_ADD(CURRENT_TIME, INTERVAL 4 MONTH) < 7";

        $this->assertEquals($sql, $q->getSql());
    }

    /**
     * @expectedException Doctrine\ORM\Query\QueryException
     */
    public function testDateAdd2()
    {
        $dql = "SELECT p FROM Entities\BlogPost p WHERE DATEADD(CURRENT_TIME(), p.created) < 7";
        $q = $this->entityManager->createQuery($dql);

        $sql = '';

        $this->assertEquals($sql, $q->getSql());
    }

	public function testStrToDate()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Query\BlogPost p WHERE STR_TO_DATE(p.created, :dateFormat) < :currentTime";
        $q = $this->entityManager->createQuery($dql);
		$q->setParameter('dateFormat', '%Y-%m-%d %h:%i %p');
		$q->setParameter('currentTime', date('Y-m-d H:i:s'));

        $this->assertEquals('SELECT b0_.id AS id0, b0_.testSet AS testSet1, b0_.created AS created2 FROM BlogPost b0_ WHERE STR_TO_DATE(b0_.created, ?) < ?', $q->getSql());
    }

    public function testFindInSet()
    {
        $dql = "SELECT p FROM DoctrineExtensions\Query\BlogPost p WHERE FIND_IN_SET(p.id, p.testSet) != 0";
        $q = $this->entityManager->createQuery($dql);

        $this->assertEquals('SELECT b0_.id AS id0, b0_.testSet AS testSet1, b0_.created AS created2 FROM BlogPost b0_ WHERE FIND_IN_SET(b0_.id, b0_.testSet) <> 0', $q->getSql());
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
