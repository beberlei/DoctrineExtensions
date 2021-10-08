<?php

namespace DoctrineExtensions\Tests\Query;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

class DbTestCase extends TestCase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    public function setUp(): void
    {
        $this->configuration = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../Entities'], true);
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
