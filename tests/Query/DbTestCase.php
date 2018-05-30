<?php

namespace DoctrineExtensions\tests\Query;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class DbTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration();
        $this->configuration->setMetadataCacheImpl(new ArrayCache());
        $this->configuration->setQueryCacheImpl(new ArrayCache());
        $this->configuration->setProxyDir(__DIR__ . '/Proxies');
        $this->configuration->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $this->configuration->setAutoGenerateProxyClasses(true);
        $this->configuration->setMetadataDriverImpl($this->configuration->newDefaultAnnotationDriver(__DIR__ . '/../Entities'));
        $this->entityManager = EntityManager::create(['driver' => 'pdo_sqlite', 'memory' => true ], $this->configuration);
    }

    public function assertDqlProducesSql($actualDql, $expectedSql, $params = [])
    {
        $q = $this->entityManager->createQuery($actualDql);

        foreach ($params as $key => $value) {
            $q->setParameter($key, $value);
        }

        $actualSql = $q->getSql();

        $this->assertEquals($expectedSql, $actualSql);
    }
}
