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

require_once 'Zend/Date.php';

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineExtensions\PHPUnit\OrmTestCase;
use DoctrineExtensions\PHPUnit\Event\EntityManagerEventArgs;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Zend_Date object.
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Types
 * @author      Andreas Gallien <gallien@seleos.de>
 * @license     New BSD License
 */
class ZendDateTest extends OrmTestCase
{
    public static function setUpBeforeClass() 
    {
        \Doctrine\DBAL\Types\Type::addType('zenddate', 
            'DoctrineExtensions\Types\ZendDateType'
        );
    }
     
    protected function createEntityManager() 
    {
    	$eventManager = new EventManager();
    	$eventManager->addEventListener(array('preTestSetUp'), $this);

        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver());
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Types\Proxies');
       
        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

	    return EntityManager::create($conn, $config, $eventManager);
    }

    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/_files/fixture.xml'); 
    }
    
    public function preTestSetUp(EntityManagerEventArgs $eventArgs)
    {
    	$em = $eventArgs->getEntityManager();

        $classes = array(
            $em->getClassMetadata(__NAMESPACE__ . '\Date'),
        );
        
    	$schemaTool = new SchemaTool($em);
        $schemaTool->dropDatabase();
    	$schemaTool->createSchema($classes);
    }
    
    public function testGetZendDate()
    {
        $em = $this->getEntityManager(); 
        
        $compareDate = new \Zend_Date(
            array('year' => 2012, 'month' => 11, 'day' => 10,
                  'hour' => 9, 'minute' => 8, 'second' => 7)
        );
        
        $date = $em->find('DoctrineExtensions\Types\Date', 1);
        $zendDate = $date->date;
        
        $this->assertTrue($zendDate instanceof \Zend_Date);
        $this->assertTrue($zendDate->equals($compareDate));
    }
    
    public function testSetZendDate()
    {
        $em = $this->getEntityManager(); 
        
        $compareDate = new \Zend_Date(
            array('year' => 2012, 'month' => 11, 'day' => 10,
                  'hour' => 9, 'minute' => 8, 'second' => 7)
        );
        $date = new Date(2, $compareDate);
        $em->persist($date);
        $em->flush();
        
        $date = $em->find('DoctrineExtensions\Types\Date', 2);
        $zendDate = $date->date;
        
        $this->assertTrue($zendDate instanceof \Zend_Date);
        $this->assertTrue($zendDate->equals($compareDate)); 
    }
}

/**
 * @Entity
 * @Table(name="dates") 
 */
class Date
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /**
     * @Column(type="zenddate")
     */
    public $date;
    
    public function __construct($id, $date) 
    {
        $this->id = $id;
        $this->date = $date;    
    }
}
