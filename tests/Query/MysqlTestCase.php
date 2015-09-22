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
            'DATEDIFF' => 'DoctrineExtensions\Query\Mysql\DateDiff',
            'DATESUB'  => 'DoctrineExtensions\Query\Mysql\DateSub',
            'FROM_UNIXTIME' => 'DoctrineExtensions\Query\Mysql\FromUnixtime'
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
            'ASCII'             => 'DoctrineExtensions\Query\Mysql\Ascii',
            'CHAR_LENGTH'       => 'DoctrineExtensions\Query\Mysql\CharLength',
            'CONCAT_WS'         => 'DoctrineExtensions\Query\Mysql\ConcatWs',
            'FIELD'             => 'DoctrineExtensions\Query\Mysql\Field',
            'FIND_IN_SET'       => 'DoctrineExtensions\Query\Mysql\FindInSet',
            'LEAST'             => 'DoctrineExtensions\Query\Mysql\Least',
            'REPLACE'           => 'DoctrineExtensions\Query\Mysql\Replace',
            'SOUNDEX'           => 'DoctrineExtensions\Query\Mysql\Soundex',
            'STR_TO_DATE'       => 'DoctrineExtensions\Query\Mysql\StrToDate',
            'SUBSTRING_INDEX'   => 'DoctrineExtensions\Query\Mysql\SubstringIndex'
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
