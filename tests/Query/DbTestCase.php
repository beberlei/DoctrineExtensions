<?php

namespace DoctrineExtensions\Tests\Query;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

use const PHP_VERSION_ID;

class DbTestCase extends TestCase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    public function setUp(): void
    {
        if (PHP_VERSION_ID < 80000) {
            $this->configuration = new Configuration();
            $this->configuration->setMetadataDriverImpl(ORMSetup::createDefaultAnnotationDriver([__DIR__ . '/../../Entities']));
        } else {
            $this->configuration = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/../Entities'], true);
        }

        $this->configuration->setMetadataCache(new ArrayAdapter());
        $this->configuration->setQueryCache(new ArrayAdapter());
        $this->configuration->setProxyDir(__DIR__ . '/Proxies');
        $this->configuration->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $this->configuration->setAutoGenerateProxyClasses(true);
        $this->entityManager = new EntityManager(
            DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true], $this->configuration),
            $this->configuration
        );
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
