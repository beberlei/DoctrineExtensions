<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineExtensions\Tests\Entities\CarbonDate as Entity;
use PHPUnit\Framework\TestCase;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Carbon/Carbon object.
 *
 * @author Steve Lacey <steve@stevelacey.net>
 */
class CarbonDateTest extends TestCase
{
    private $em;

    public static function setUpBeforeClass(): void
    {
        Type::addType('CarbonDate', 'DoctrineExtensions\Types\CarbonDateType');
        Type::addType('CarbonDateTime', 'DoctrineExtensions\Types\CarbonDateTimeType');
        Type::addType('CarbonDateTimeTz', 'DoctrineExtensions\Types\CarbonDateTimeTzType');
        Type::addType('CarbonTime', 'DoctrineExtensions\Types\CarbonTimeType');
        Type::addType('CarbonImmutableDate', 'DoctrineExtensions\Types\CarbonImmutableDateType');
        Type::addType('CarbonImmutableDateTime', 'DoctrineExtensions\Types\CarbonImmutableDateTimeType');
        Type::addType('CarbonImmutableDateTimeTz', 'DoctrineExtensions\Types\CarbonImmutableDateTimeTzType');
        Type::addType('CarbonImmutableTime', 'DoctrineExtensions\Types\CarbonImmutableTimeType');
    }

    public function setUp(): void
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
            $this->em->getClassMetadata('DoctrineExtensions\Tests\Entities\CarbonDate'),
        ]);

        $entity = new Entity();
        $entity->id = 1;
        $entity->date                  = Carbon::createFromDate(2015, 1, 1);
        $entity->datetime              = Carbon::create(2015, 1, 1, 0, 0, 0);
        $entity->datetime_tz           = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');
        $entity->time                  = Carbon::createFromTime(12, 0, 0, 'Europe/London');
        $entity->date_immutable        = CarbonImmutable::createFromDate(2015, 1, 1);
        $entity->datetime_immutable    = CarbonImmutable::create(2015, 1, 1, 0, 0, 0);
        $entity->datetime_tz_immutable = CarbonImmutable::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');
        $entity->time_immutable        = CarbonImmutable::createFromTime(12, 0, 0, 'Europe/London');
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->date);
        $this->assertEquals(
            Carbon::createFromDate(2015, 1, 1, $entity->date->timezone)->format('Y-m-d'),
            $entity->date->format('Y-m-d')
        );
    }

    public function testDateSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->date = Carbon::createFromDate(2015, 1, 1);

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testDateTimeGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->datetime);
        $this->assertEquals(Carbon::create(2015, 1, 1, 0, 0, 0), $entity->datetime);
    }

    public function testDateTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime = Carbon::create(2015, 1, 1, 0, 0, 0);

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testDateTimeTzGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->datetime_tz);
        $this->assertEquals(Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific'), $entity->datetime_tz);
    }

    public function testDateTimeTzSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime_tz = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testTimeGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->time);
        $this->assertEquals(Carbon::createFromTime(12, 0, 0, 'Europe/London'), $entity->time);
    }

    public function testTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->time = Carbon::createFromTime(12, 0, 0, 'Europe/London');

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testImmutableDateGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\CarbonImmutable', $entity->date_immutable);
        $this->assertEquals(
            CarbonImmutable::createFromDate(2015, 1, 1, $entity->date->timezone)->format('Y-m-d'),
            $entity->date->format('Y-m-d')
        );
    }

    public function testImmutableDateSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->date = CarbonImmutable::createFromDate(2015, 1, 1);

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testImmutableDateTimeGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\CarbonImmutable', $entity->datetime_immutable);
        $this->assertEquals(CarbonImmutable::create(2015, 1, 1, 0, 0, 0), $entity->datetime);
    }

    public function testImmutableDateTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime = CarbonImmutable::create(2015, 1, 1, 0, 0, 0);

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testImmutableDateTimeTzGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\CarbonImmutable', $entity->datetime_tz_immutable);
        $this->assertEquals(CarbonImmutable::create(2012, 1, 1, 0, 0, 0, 'US/Pacific'), $entity->datetime_tz);
    }

    public function testImmutableDateTimeTzSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime_tz = CarbonImmutable::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    public function testImmutableTimeGetter(): void
    {
        $entity = $this->em->find('DoctrineExtensions\Tests\Entities\CarbonDate', 1);

        $this->assertInstanceOf('Carbon\CarbonImmutable', $entity->time_immutable);
        $this->assertEquals(CarbonImmutable::createFromTime(12, 0, 0, 'Europe/London'), $entity->time);
    }

    public function testImmutableTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->time = CarbonImmutable::createFromTime(12, 0, 0, 'Europe/London');

        $this->em->persist($entity);
        $this->assertNull($this->em->flush());
    }

    /**
     * @dataProvider typeProvider
     */
    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint($type): void
    {
        /** @var \Doctrine\DBAL\Platforms\AbstractPlatform $platform */
        $platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');

        $this->assertTrue(Type::getType($type)->requiresSQLCommentHint($platform));
    }

    public function typeProvider()
    {
        return [
            ['CarbonDate'],
            ['CarbonDateTime'],
            ['CarbonDateTimeTz'],
            ['CarbonTime'],
            ['CarbonImmutableDate'],
            ['CarbonImmutableDateTime'],
            ['CarbonImmutableDateTimeTz'],
            ['CarbonImmutableTime'],
        ];
    }
}
