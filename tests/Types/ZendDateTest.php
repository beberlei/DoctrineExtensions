<?php

namespace DoctrineExtensions\Tests\Types;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineExtensions\Tests\Entities\ZendDate;
use PHPUnit\Framework\TestCase;
use Zend_Date;

use function assert;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 */
class ZendDateTest extends TestCase
{
    private $em;

    public static function setUpBeforeClass(): void
    {
        Type::addType(
            'ZendDate',
            'DoctrineExtensions\Types\ZendDateType'
        );
    }

    public function setUp(): void
    {
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\PHPUnit\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/../../Entities'));

        $this->em = EntityManager::create(
            [
                'driver' => 'pdo_sqlite',
                'memory' => true,
            ],
            $config
        );

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema([
            $this->em->getClassMetadata('DoctrineExtensions\Tests\Entities\ZendDate'),
        ]);

        $this->em->persist(new ZendDate(1, new Zend_Date([
            'year' => 2012,
            'month' => 11,
            'day' => 10,
            'hour' => 9,
            'minute' => 8,
            'second' => 7,
        ])));

        $this->em->flush();
    }

    public function testGetZendDate(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\ZendDate', 1);

        $this->assertInstanceOf('Zend_Date', $entity->date);
        $this->assertTrue($entity->date->equals(new Zend_Date([
            'year' => 2012,
            'month' => 11,
            'day' => 10,
            'hour' => 9,
            'minute' => 8,
            'second' => 7,
        ])));
    }

    public function testSetZendDate(): void
    {
        $zendDate = new Zend_Date([
            'year' => 2012,
            'month' => 11,
            'day' => 10,
            'hour' => 9,
            'minute' => 8,
            'second' => 7,
        ]);

        $entity = new ZendDate(2, $zendDate);
        $this->em->persist($entity);
        $this->em->flush();

        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\ZendDate', 2);

        $this->assertInstanceOf('Zend_Date', $entity->date);
        $this->assertTrue($entity->date->equals($zendDate));
    }

    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint(): void
    {
        $platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
        assert($platform instanceof AbstractPlatform);

        $this->assertTrue(Type::getType('ZendDate')->requiresSQLCommentHint($platform));
    }
}
