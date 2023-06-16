<?php

namespace DoctrineExtensions\Tests\Query;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

abstract class DbTestCase extends TestCase
{
    public EntityManager $entityManager;

    protected Configuration $configuration;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->configuration->setMetadataCache(new ArrayAdapter());
        $this->configuration->setQueryCache(new ArrayAdapter());
        $this->configuration->setProxyDir(__DIR__ . '/Proxies');
        $this->configuration->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $this->configuration->setAutoGenerateProxyClasses(true);
        $this->configuration->setMetadataDriverImpl(new AttributeDriver([__DIR__ . '/../Entities']));

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ], $this->configuration);

        $this->entityManager = new EntityManager($connection, $this->configuration);
    }

    public function assertDqlProducesSql(string $actualDql, string $expectedSql, array $params = []): void
    {
        $q = $this->entityManager->createQuery($actualDql);

        foreach ($params as $key => $value) {
            $q->setParameter($key, $value);
        }

        $actualSql = $q->getSql();

        $this->assertEquals($expectedSql, $actualSql);
    }
}
