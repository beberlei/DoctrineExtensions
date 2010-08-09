<?php

namespace DoctrineExtensions\PHPUnit;

require_once __DIR__."/../TestHelper.php";

class OrmTestCaseTest extends OrmTestCase
{
    private $preTestEvent = false;
    private $postTestEvent = false;

    public function testFixtureLoaded()
    {
        $em = $this->getEntityManager();
        $user = $em->find('DoctrineExtensions\PHPUnit\User', 1);

        $this->assertEquals('beberlei', $user->name);
        $this->assertEquals('kontakt@beberlei.de', $user->email);
    }

    public function testEventsCalled()
    {
        $this->assertTrue($this->preTestEvent, "PreTestSetUp Event not called.");
        $this->assertTrue($this->postTestEvent, "PostTestSetUp Event not called.");
    }

    public function testCreateQueryDataSetAssertion()
    {
        $ds = $this->createQueryDataSet(array('users'));

        $this->assertDataSetsEqual($this->getDataSet(), $ds);
    }

    public function testCreateQueryTableAssertion()
    {
        $table = $this->createQueryDataTable('users');

        $this->assertTablesEqual($this->getDataSet()->getTable('users'), $table);
    }

    protected function createEntityManager()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver());
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\PHPUnit\Proxies');
        
        $eventManager = new \Doctrine\Common\EventManager();
        $eventManager->addEventListener(array("preTestSetUp", "postTestSetUp"), $this);

        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        return \Doctrine\ORM\EntityManager::create($conn, $config, $eventManager);
    }

    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__."/_files/fixture.xml");
    }

    public function preTestSetUp(Event\EntityManagerEventArgs $eventArgs)
    {
        $this->preTestEvent = true;

        $em = $eventArgs->getEntityManager();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);

        $classes = array(
            $em->getClassMetadata(__NAMESPACE__."\User"),
        );

        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);
    }

    public function postTestSetUp(Event\EntityManagerEventArgs $eventArgs)
    {
        $this->postTestEvent = true;
    }
}

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /**
     * @Column
     */
    public $name;

    /**
     * @Column
     */
    public $email;
}