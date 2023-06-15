<?php

namespace DoctrineExtensions\Tests\Types;

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use DoctrineExtensions\Tests\Entities\ZendDate;
use DoctrineExtensions\Types\ZendDateType;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @author Andreas Gallien <gallien@seleos.de>
 */
class ZendDateTest extends TestCase
{
    private EntityManager $em;

    public static function setUpBeforeClass(): void
    {
        Type::addType(
            'ZendDate',
            ZendDateType::class
        );
    }

    public function setUp(): void
    {
        $config = new Configuration();
        $config->setMetadataCache(new ArrayAdapter());
        $config->setQueryCache(new ArrayAdapter());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\PHPUnit\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl(new AttributeDriver([__DIR__ . '/../Entities']));

        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'memory' => true
        ], $config);

        $this->em = new EntityManager($connection, $config);

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema([
            $this->em->getClassMetadata(ZendDate::class),
        ]);

        $this->em->persist(new ZendDate(1, new \Zend_Date([
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7,
        ])));

        $this->em->flush();
    }

    public function testGetZendDate():void
    {
        $entity = $this->em->find(ZendDate::class, 1);

        $this->assertInstanceOf('Zend_Date', $entity->date);
        $this->assertTrue($entity->date->equals(new \Zend_Date([
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7,
        ])));
    }

    public function testSetZendDate():void
    {
        $zendDate = new \Zend_Date([
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7,
        ]);

        $entity = new ZendDate(2, $zendDate);
        $this->em->persist($entity);
        $this->em->flush();

        $entity = $this->em->find(ZendDate::class, 2);

        $this->assertInstanceOf('Zend_Date', $entity->date);
        $this->assertTrue($entity->date->equals($zendDate));
    }

    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint():void
    {
        $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

        $this->assertTrue(Type::getType('ZendDate')->requiresSQLCommentHint($platform));
    }
}
