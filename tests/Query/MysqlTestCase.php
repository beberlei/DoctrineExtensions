<?php

namespace DoctrineExtensions\Tests\Query;

class MysqlTestCase extends \PHPUnit_Framework_TestCase
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

        $config->setCustomDatetimeFunctions(array(
            'DATEADD'  => 'DoctrineExtensions\Query\Mysql\DateAdd',
            'DATEDIFF' => 'DoctrineExtensions\Query\Mysql\DateDiff'
        ));

        $config->setCustomNumericFunctions(array(
            'ACOS'    => 'DoctrineExtensions\Query\Mysql\Acos',
            'ASIN'    => 'DoctrineExtensions\Query\Mysql\Asin',
            'ATAN'    => 'DoctrineExtensions\Query\Mysql\Atan',
            'ATAN2'   => 'DoctrineExtensions\Query\Mysql\Atan2',
            'COS'     => 'DoctrineExtensions\Query\Mysql\Cos',
            'COT'     => 'DoctrineExtensions\Query\Mysql\Cot',
            'DEGREES' => 'DoctrineExtensions\Query\Mysql\Degrees',
            'RADIANS' => 'DoctrineExtensions\Query\Mysql\Radians',
            'SIN'     => 'DoctrineExtensions\Query\Mysql\Sin',
            'TAN'     => 'DoctrineExtensions\Query\Mysql\Tan'
        ));

        $config->setCustomStringFunctions(array(
            'CHAR_LENGTH' => 'DoctrineExtensions\Query\Mysql\CharLength',
            'CONCAT_WS'   => 'DoctrineExtensions\Query\Mysql\ConcatWs',
            'FIELD'       => 'DoctrineExtensions\Query\Mysql\Field',
            'FIND_IN_SET' => 'DoctrineExtensions\Query\Mysql\FindInSet',
            'REPLACE'     => 'DoctrineExtensions\Query\Mysql\Replace',
            'SOUNDEX'     => 'DoctrineExtensions\Query\Mysql\Soundex',
            'STR_TO_DATE' => 'DoctrineExtensions\Query\Mysql\StrToDate'
        ));

        $this->entityManager = \Doctrine\ORM\EntityManager::create(
            array('driver' => 'pdo_sqlite', 'memory' => true),
            $config
        );
    }
}
