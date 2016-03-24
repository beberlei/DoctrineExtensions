<?php

namespace DoctrineExtensions\Tests\Query;

class OracleTestCase extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();

        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/../Entities'));

        $config->setCustomStringFunctions(array(
            'LISTAGG' => 'DoctrineExtensions\Query\Oracle\Listagg',
        ));

        $this->entityManager = \Doctrine\ORM\EntityManager::create(
            array('driver' => 'pdo_sqlite', 'memory' => true),
            $config
        );
    }

    public static function assertEquals($expected, $actual, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        // expectation patch to support pre Doctrine 2.5 field aliases
        if (\Doctrine\ORM\Version::compare('2.5.0') == 1) {
            $expected = preg_replace('/(\w+)_([0-9])/', '\1\2', $expected);
        }

        return parent::assertEquals($expected, $actual, $message);
    }
}
