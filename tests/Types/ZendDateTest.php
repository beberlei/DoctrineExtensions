<?php

namespace DoctrineExtensions\Tests\Types;

use Doctrine\ORM\Tools\SchemaTool;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @author Andreas Gallien <gallien@seleos.de>
 */
class ZendDateTest extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public static function setUpBeforeClass()
    {
        \Doctrine\DBAL\Types\Type::addType(
            'ZendDate',
            'DoctrineExtensions\Types\ZendDateType'
        );
    }

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\PHPUnit\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/../../Entities'));

        $this->em = \Doctrine\ORM\EntityManager::create(
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

        $this->em->persist(new \DoctrineExtensions\Tests\Entities\ZendDate(1, new \Zend_Date([
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7,
        ])));

        $this->em->flush();
    }

    public function testGetZendDate()
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\ZendDate', 1);

        $this->assertInstanceOf('Zend_Date', $entity->date);
        $this->assertTrue($entity->date->equals(new \Zend_Date([
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7,
        ])));
    }

    public function testSetZendDate()
    {
        $zendDate = new \Zend_Date([
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7,
        ]);

        $entity = new \DoctrineExtensions\Tests\Entities\ZendDate(2, $zendDate);
        $this->em->persist($entity);
        $this->em->flush();

        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\ZendDate', 2);

        $this->assertInstanceOf('Zend_Date', $entity->date);
        $this->assertTrue($entity->date->equals($zendDate));
    }

    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint()
    {
        /** @var \Doctrine\DBAL\Platforms\AbstractPlatform $platform */
        $platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');

        $this->assertTrue(\Doctrine\DBAL\Types\Type::getType('ZendDate')->requiresSQLCommentHint($platform));
    }
}
