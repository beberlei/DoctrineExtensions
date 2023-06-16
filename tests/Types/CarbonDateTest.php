<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineExtensions\Tests\Entities\CarbonDate as Entity;
use DoctrineExtensions\Types\CarbonDateTimeType;
use DoctrineExtensions\Types\CarbonDateTimeTzType;
use DoctrineExtensions\Types\CarbonDateType;
use DoctrineExtensions\Types\CarbonImmutableDateTimeType;
use DoctrineExtensions\Types\CarbonImmutableDateTimeTzType;
use DoctrineExtensions\Types\CarbonImmutableDateType;
use DoctrineExtensions\Types\CarbonImmutableTimeType;
use DoctrineExtensions\Types\CarbonTimeType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Carbon/Carbon object.
 *
 * @author Steve Lacey <steve@stevelacey.net>
 */
final class CarbonDateTest extends TestCase
{
    private EntityManager $em;

    public static function setUpBeforeClass(): void
    {
        Type::addType('CarbonDate', CarbonDateType::class);
        Type::addType('CarbonDateTime', CarbonDateTimeType::class);
        Type::addType('CarbonDateTimeTz', CarbonDateTimeTzType::class);
        Type::addType('CarbonTime', CarbonTimeType::class);
        Type::addType('CarbonImmutableDate', CarbonImmutableDateType::class);
        Type::addType('CarbonImmutableDateTime', CarbonImmutableDateTimeType::class);
        Type::addType('CarbonImmutableDateTimeTz', CarbonImmutableDateTimeTzType::class);
        Type::addType('CarbonImmutableTime', CarbonImmutableTimeType::class);
    }

    protected function setUp(): void
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
            'memory' => true,
        ], $config);

        $this->em = new EntityManager($connection, $config);

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema([
            $this->em->getClassMetadata(Entity::class),
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
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(Carbon::class, $entity->date);
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
        $this->em->flush();
    }

    public function testDateTimeGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(Carbon::class, $entity->datetime);
        $this->assertEquals(Carbon::create(2015, 1, 1, 0, 0, 0), $entity->datetime);
    }

    public function testDateTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime = Carbon::create(2015, 1, 1, 0, 0, 0);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateTimeTzGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(Carbon::class, $entity->datetime_tz);
        $this->assertEquals(Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific'), $entity->datetime_tz);
    }

    public function testDateTimeTzSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime_tz = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testTimeGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(Carbon::class, $entity->time);
        $this->assertEquals(Carbon::createFromTime(12, 0, 0, 'Europe/London'), $entity->time);
    }

    public function testTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->time = Carbon::createFromTime(12, 0, 0, 'Europe/London');

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testImmutableDateGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(CarbonImmutable::class, $entity->date_immutable);
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
        $this->em->flush();
    }

    public function testImmutableDateTimeGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(CarbonImmutable::class, $entity->datetime_immutable);
        $this->assertEquals(CarbonImmutable::create(2015, 1, 1, 0, 0, 0), $entity->datetime);
    }

    public function testImmutableDateTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime = CarbonImmutable::create(2015, 1, 1, 0, 0, 0);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testImmutableDateTimeTzGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(CarbonImmutable::class, $entity->datetime_tz_immutable);
        $this->assertEquals(CarbonImmutable::create(2012, 1, 1, 0, 0, 0, 'US/Pacific'), $entity->datetime_tz);
    }

    public function testImmutableDateTimeTzSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->datetime_tz = CarbonImmutable::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testImmutableTimeGetter(): void
    {
        $entity = $this->em->find(Entity::class, 1);

        $this->assertInstanceOf(CarbonImmutable::class, $entity->time_immutable);
        $this->assertEquals(CarbonImmutable::createFromTime(12, 0, 0, 'Europe/London'), $entity->time);
    }

    public function testImmutableTimeSetter(): void
    {
        $entity = new Entity();
        $entity->id = 2;
        $entity->time = CarbonImmutable::createFromTime(12, 0, 0, 'Europe/London');

        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @dataProvider typeProvider
     */
    public function testTypesThatMapToAlreadyMappedDatabaseTypesRequireCommentHint($type): void
    {
        $platform = $this->getMockForAbstractClass(AbstractPlatform::class);

        $this->assertTrue(Type::getType($type)->requiresSQLCommentHint($platform));
    }

    public static function typeProvider(): array
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
