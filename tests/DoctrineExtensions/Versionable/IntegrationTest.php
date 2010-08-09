<?php

namespace DoctrineExtensions\Versionable;

use DoctrineExtensions\PHPUnit\OrmTestCase;
use DoctrineExtensions\PHPUnit\Event\EntityManagerEventArgs;

class IntegrationTest extends OrmTestCase
{
    public function testMakeVersionSnapshot()
    {
        $em = $this->getEntityManager();
        $em->getEventManager()->addEventSubscriber(new VersionListener());

        $post = $em->find(__NAMESPACE__."\BlogPost", 1);

        $post->title = "Foozbaz!";
        $post->content = "Oerr!";

        $em->flush();

        $versionManager = new VersionManager($em);
        $versions = $versionManager->getVersions($post);
        $this->assertEquals(1, count($versions));

        $aVersion = $versions[1];
        
        /* @var $aVersion DoctrineExtensions\Versionable\Entity\ResourceVersion */
        $this->assertType('DoctrineExtensions\Versionable\Entity\ResourceVersion', $aVersion);
        $this->assertEquals("DoctrineExtensions\Versionable\BlogPost", $aVersion->getResourceName());
        $this->assertEquals('Hello World!', $aVersion->getVersionedData('title'));
        $this->assertEquals('Barbaz', $aVersion->getVersionedData('content'));
        $this->assertEquals(1, $aVersion->getVersion());
    }

    public function testRevert()
    {
        $em = $this->getEntityManager();
        $em->getEventManager()->addEventSubscriber(new VersionListener());

        $post = $em->find(__NAMESPACE__."\BlogPost", 2);

        $this->assertEquals("bar", $post->title);
        $this->assertEquals("bar", $post->content);

        $versionManager = new VersionManager($em);
        $versionManager->revert($post, 1);

        $this->assertEquals("foo", $post->title);
        $this->assertEquals("foo", $post->content);
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
        $eventManager->addEventListener(array("preTestSetUp"), $this);

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

    public function preTestSetUp(EntityManagerEventArgs $eventArgs)
    {
        $this->preTestEvent = true;

        $em = $eventArgs->getEntityManager();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);

        $classes = array(
            $em->getClassMetadata(__NAMESPACE__."\BlogPost"),
            $em->getClassMetadata('DoctrineExtensions\Versionable\Entity\ResourceVersion'),
        );

        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);
    }
}

/**
 * @Entity
 * @Table(name="posts")
 */
class BlogPost implements Versionable
{
    /**
     * @Id @column(type="integer") @generatedValue
     */
    public $id;

    /**
     * @column(type="string")
     */
    public $title;

    /**
     * @column(type="text")
     */
    public $content;

    /**
     * @Column(type="integer")
     * @version
     */
    public $version;
}