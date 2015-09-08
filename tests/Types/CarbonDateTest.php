<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon,
    Doctrine\ORM\Tools\SchemaTool,
    DoctrineExtensions\Tests\Entities\CarbonDate as Entity,
    Doctrine\DBAL\Types\Type;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Carbon/Carbon object.
 *
 * @author Steve Lacey <steve@stevelacey.net>
 */
class CarbonDateTest extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public static function setUpBeforeClass()
    {
        Type::addType('CarbonDate', 'DoctrineExtensions\Types\CarbonDateType');
        Type::addType('CarbonDateTime', 'DoctrineExtensions\Types\CarbonDateTimeType');
        Type::addType('CarbonDateTimeTz', 'DoctrineExtensions\Types\CarbonDateTimeTzType');
        Type::addType('CarbonTime', 'DoctrineExtensions\Types\CarbonTimeType');
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
            array(
                'driver' => 'pdo_sqlite',
                'memory' => true,
            ),
            $config
        );

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema(array(
            $this->em->getClassMetadata('DoctrineExtensions\Tests\Entities\CarbonDate'),
        ));

        $entity = new Entity();
        $entity->id = 1;
        $entity->date        = Carbon::createFromDate(2015, 1, 1);
        $entity->datetime    = Carbon::create(2015, 1, 1, 0, 0, 0);
        $entity->datetime_tz = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');
        $entity->time        = Carbon::createFromTime(12, 0, 0, 'Europe/London');
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateGetter()
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->date);
        $this->assertEquals(
            Carbon::createFromDate(2015, 1, 1, $entity->date->timezone)->format('Y-m-d'),
            $entity->date->format('Y-m-d')
        );
    }

    public function testDateSetter()
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->date = Carbon::createFromDate(2015, 1, 1);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateTimeGetter()
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->datetime);
        $this->assertEquals(Carbon::create(2015, 1, 1, 0, 0, 0), $entity->datetime);
    }

    public function testDateTimeSetter()
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime = Carbon::create(2015, 1, 1, 0, 0, 0);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateTimeTzGetter()
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->datetime_tz);
        $this->assertEquals(Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific'), $entity->datetime_tz);
    }

    public function testDateTimeTzSetter()
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime_tz = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testTimeGetter()
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->time);
        $this->assertEquals(Carbon::createFromTime(12, 0, 0, 'Europe/London'), $entity->time);
    }

    public function testTimeSetter()
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->time = Carbon::createFromTime(12, 0, 0, 'Europe/London');

        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @dataProvider typeProvider
     */
    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint($type)
    {
        /** @var \Doctrine\DBAL\Platforms\AbstractPlatform $platform */
        $platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');

        $this->assertTrue(Type::getType($type)->requiresSQLCommentHint($platform));
    }

    public function typeProvider()
    {
        return array(
            array('CarbonDate'),
            array('CarbonDateTime'),
            array('CarbonDateTimeTz'),
            array('CarbonTime'),
        );
    }
}
