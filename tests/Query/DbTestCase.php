<?php

namespace DoctrineExtensions\Tests\Query;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class DbTestCase extends TestCase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    public function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->configuration->setMetadataCache(new ArrayAdapter());
        $this->configuration->setQueryCache(new ArrayAdapter());
        $this->configuration->setProxyDir(__DIR__ . '/Proxies');
        $this->configuration->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $this->configuration->setAutoGenerateProxyClasses(true);
        $this->configuration->setMetadataDriverImpl($this->configuration->newDefaultAnnotationDriver(__DIR__ . '/../Entities'));
        $this->entityManager = EntityManager::create(['driver' => 'pdo_sqlite', 'memory' => true], $this->configuration);
    }

    public function assertDqlProducesSql($actualDql, $expectedSql, $params = []): void
    {
        $q = $this->entityManager->createQuery($actualDql);

        foreach ($params as $key => $value) {
            $q->setParameter($key, $value);
        }

        $actualSql = $q->getSql();

        $this->assertEquals($expectedSql, $actualSql);
    }
}
