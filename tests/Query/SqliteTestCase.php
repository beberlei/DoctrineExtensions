<?php

namespace DoctrineExtensions\Tests\Query;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineExtensions\Query\Sqlite\Date;
use DoctrineExtensions\Query\Sqlite\Day;
use DoctrineExtensions\Query\Sqlite\Hour;
use DoctrineExtensions\Query\Sqlite\Minute;
use DoctrineExtensions\Query\Sqlite\Month;
use DoctrineExtensions\Query\Sqlite\StrfTime;
use DoctrineExtensions\Query\Sqlite\Week;
use DoctrineExtensions\Query\Sqlite\WeekDay;
use DoctrineExtensions\Query\Sqlite\Year;

class SqliteTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerInterface
     */
    public $entityManager = null;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();

        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl(
            $config->newDefaultAnnotationDriver(__DIR__ . '/../Entities')
        );

        $config->setCustomDatetimeFunctions(
            array(
                'YEAR' => 'DoctrineExtensions\Query\Sqlite\Year',
                'WEEKDAY' => 'DoctrineExtensions\Query\Sqlite\WeekDay',
                'WEEK' => 'DoctrineExtensions\Query\Sqlite\Week',
                'Month' => 'DoctrineExtensions\Query\Sqlite\Month',
                'MINUTE' => 'DoctrineExtensions\Query\Sqlite\Minute',
                'HOUR' => 'DoctrineExtensions\Query\Sqlite\Hour',
                'DAY' => 'DoctrineExtensions\Query\Sqlite\Day',
                'DATE' => 'DoctrineExtensions\Query\Sqlite\Date',
                'STRFTIME' => 'DoctrineExtensions\Query\Sqlite\StrfTime',

            )
        );
        $this->entityManager = \Doctrine\ORM\EntityManager::create(
            array('driver' => 'pdo_sqlite', 'memory' => true),
            $config
        );
    }
}
