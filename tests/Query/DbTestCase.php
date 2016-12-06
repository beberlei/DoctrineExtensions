<?php
namespace DoctrineExtensions\tests\Query;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class DbTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration();
        $this->configuration->setMetadataCacheImpl( new ArrayCache() );
        $this->configuration->setQueryCacheImpl( new ArrayCache() );
        $this->configuration->setProxyDir( __DIR__ . '/Proxies' );
        $this->configuration->setProxyNamespace( 'DoctrineExtensions\Tests\Proxies' );
        $this->configuration->setAutoGenerateProxyClasses( true );
        $this->configuration->setMetadataDriverImpl( $this->configuration->newDefaultAnnotationDriver( __DIR__ . '/../Entities' ) );
        $this->entityManager = EntityManager::create(array('driver' => 'pdo_sqlite', 'memory' => true ), $this->configuration);
    }

    /**
     * @@inheritdoc
     */
    public static function assertEquals($expected, $actual, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        // Expectation patch to support pre Doctrine 2.5 field aliases
        if (\Doctrine\ORM\Version::compare('2.5.0') == 1) {
            $expected = preg_replace('/(\w+)_([0-9])/', '\1\2', $expected);
        }

        return parent::assertEquals($expected, $actual, $message);
    }

}
