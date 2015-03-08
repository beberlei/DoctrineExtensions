<?php

/*
 * DoctrineExtensions Types
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Types;

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/../../Entities/Date.php';

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Types
 * @author      Andreas Gallien <gallien@seleos.de>
 * @license     New BSD License
 */

class ZendDateTest extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public static function setUpBeforeClass()
    {
        \Doctrine\DBAL\Types\Type::addType('zenddate',
            'DoctrineExtensions\Types\ZendDateType'
        );
    }

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\PHPUnit\Proxies');
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
            $this->em->getClassMetadata('Entities\Date'),
        ));

        $this->em->persist(new \Entities\Date(1, new \Zend_Date(array(
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7
        ))));

        $this->em->flush();
    }

    public function testGetZendDate()
    {
        $entity = $this->em->find('Entities\Date', 1);

        $this->assertTrue($entity->date instanceof \Zend_Date);
        $this->assertTrue($entity->date->equals(new \Zend_Date(array(
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7
        ))));
    }

    public function testSetZendDate()
    {
        $zendDate = new \Zend_Date(array(
            'year' => 2012, 'month' => 11, 'day' => 10,
            'hour' => 9, 'minute' => 8, 'second' => 7
        ));

        $entity = new \Entities\Date(2, $zendDate);
        $this->em->persist($entity);
        $this->em->flush();

        $entity = $this->em->find('Entities\Date', 2);

        $this->assertTrue($entity->date instanceof \Zend_Date);
        $this->assertTrue($entity->date->equals($zendDate));
    }
}
