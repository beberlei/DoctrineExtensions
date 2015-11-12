<?php

namespace DoctrineExtensions\Tests\Query;

use Doctrine\ORM\EntityManagerInterface;

class SqliteTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerInterface
     */
    public $entityManager = null;

    /**
     * @var string name of Date.
     */
    protected $columnAlias;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();

        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir(__DIR__.'/Proxies');
        $config->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl(
            $config->newDefaultAnnotationDriver(__DIR__.'/../Entities')
        );

        $config->setCustomDatetimeFunctions(
            array(
                'YEAR'     => 'DoctrineExtensions\Query\Sqlite\Year',
                'WEEKDAY'  => 'DoctrineExtensions\Query\Sqlite\WeekDay',
                'WEEK'     => 'DoctrineExtensions\Query\Sqlite\Week',
                'Month'    => 'DoctrineExtensions\Query\Sqlite\Month',
                'MINUTE'   => 'DoctrineExtensions\Query\Sqlite\Minute',
                'HOUR'     => 'DoctrineExtensions\Query\Sqlite\Hour',
                'DAY'      => 'DoctrineExtensions\Query\Sqlite\Day',
                'DATE'     => 'DoctrineExtensions\Query\Sqlite\Date',
                'STRFTIME' => 'DoctrineExtensions\Query\Sqlite\StrfTime',
                'DATE_FORMAT' => 'DoctrineExtensions\Query\Sqlite\DateFormat',

            )
        );

        $config->setCustomNumericFunctions(
            array(
                'ROUND' => 'DoctrineExtensions\Query\Sqlite\Round',
            )
        );

        $config->setCustomStringFunctions(
            array(
                'IFNULL' => 'DoctrineExtensions\Query\Sqlite\IfNull',
                'REPLACE' => 'DoctrineExtensions\Query\Sqlite\Replace',
            )
        );

        $this->entityManager = \Doctrine\ORM\EntityManager::create(
            array('driver' => 'pdo_sqlite', 'memory' => true),
            $config
        );

        $configuration = $this->entityManager->getConfiguration();

        if (method_exists($configuration, 'getQuoteStrategy') === false) { // doctrine < 2.3
            $this->columnAlias = 'sclr0';
        } else {
            $this->columnAlias = $configuration
                ->getQuoteStrategy()
                ->getColumnAlias(
                    'sclr',
                    0,
                    $this->entityManager->getConnection()->getDatabasePlatform(),
                    $this->entityManager->getClassMetadata('DoctrineExtensions\Tests\Entities\Date')
                );
        }
    }
}
