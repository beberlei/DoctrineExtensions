<?php

namespace DoctrineExtensions\Tests\Types;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @author Andreas Gallien <gallien@seleos.de>
 */
class ZendDateTest extends TestCase
{
    private $em;

    public static function setUpBeforeClass(): void
    {
        \Doctrine\DBAL\Types\Type::addType(
            'ZendDate',
            'DoctrineExtensions\Types\ZendDateType'
        );
    }

    public function setUp(): void
    {
        $this->em = \Doctrine\ORM\EntityManager::create(
            [
                'driver' => 'pdo_sqlite',
                'memory' => true,
            ],
            Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../Entities'], true)
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
