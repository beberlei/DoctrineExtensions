DoctrineExtensions
==================

[![Build Status](https://img.shields.io/badge/branch-master-blue.svg)](https://github.com/beberlei/DoctrineExtensions/tree/master)
[![Build Status](https://travis-ci.org/beberlei/DoctrineExtensions.svg?branch=master)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Build Status](https://img.shields.io/badge/version-1.0-orange.svg)](https://github.com/beberlei/DoctrineExtensions/tree/1.0)
[![Travis branch](https://img.shields.io/travis/beberlei/DoctrineExtensions/1.0.svg)](https://travis-ci.org/beberlei/DoctrineExtensions)
[![Build Status](https://img.shields.io/badge/version-0.3-orange.svg)](https://github.com/beberlei/DoctrineExtensions/tree/0.3)
[![Travis branch](https://img.shields.io/travis/beberlei/DoctrineExtensions/0.3.svg)](https://travis-ci.org/beberlei/DoctrineExtensions)

[![Packagist](https://img.shields.io/packagist/dd/beberlei/DoctrineExtensions.svg)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dm/beberlei/DoctrineExtensions.svg)](https://packagist.org/packages/beberlei/DoctrineExtensions)
[![Packagist](https://img.shields.io/packagist/dt/beberlei/DoctrineExtensions.svg)](https://packagist.org/packages/beberlei/DoctrineExtensions)

A set of extensions to Doctrine 2 that add support for additional query
functions available in MySQL and Oracle.

**Note: 0.x versions of DoctrineExtensions are end of life, as various
functionality including Paginator, LargeCollections, Phing, PHPUnit and
Versionable are now available in Doctrine core, and were removed from
DoctrineExtensions in 1.0.**

| DB | Functions |
|:--:|:---------:|
| MySQL | `ACOS, ASIN, ATAN, ATAN2, BINARY, CHAR_LENGTH, CONCAT_WS, COS, COT, COUNTIF, CRC32, DATE, DATE_FORMAT, DATEADD, DATEDIFF, DAY, DAYNAME, DEGREES, FIELD, FIND_IN_SET, GROUP_CONCAT, HOUR, IFELSE, IFNULL, LAST_DAY, MATCH_AGAINST, MD5, MINUTE, MONTH, MONTHNAME, NULLIF, PI, POWER, QUARTER, RADIANS, RAND, REGEXP, REPLACE, ROUND, SECOND, SHA1, SHA2, SIN, SOUNDEX, STD, STRTODATE, TAN, TIME, TIMESTAMPADD, TIMESTAMPDIFF, UUID_SHORT, WEEK, WEEKDAY, YEAR` |
| Oracle | `DAY, MONTH, NVL, TODATE, TRUNC, YEAR` |

Installation
------------

To include the DoctrineExtensions you should fire up an autoloader, for example:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
$classLoader->register();
```

If you're using Symfony2 and are primarily interested in the additional MySQL functions, you can pile them into your configuration like so:

    doctrine:
         orm:
             dql:
                 datetime_functions:
                     date: DoctrineExtensions\Query\Mysql\Date
                     date_format: DoctrineExtensions\Query\Mysql\DateFormat
                     dateadd: DoctrineExtensions\Query\Mysql\DateAdd
                     datediff: DoctrineExtensions\Query\Mysql\DateDiff
                     day: DoctrineExtensions\Query\Mysql\Day
                     dayname: DoctrineExtensions\Query\Mysql\DayName
                     last_day: DoctrineExtensions\Query\Mysql\LastDay
                     minute: DoctrineExtensions\Query\Mysql\Minute
                     second: DoctrineExtensions\Query\Mysql\Second
                     strtodate: DoctrineExtensions\Query\Mysql\StrToDate
                     time: DoctrineExtensions\Query\Mysql\Time
                     timestampadd: DoctrineExtensions\Query\Mysql\TimestampAdd
                     timestampdiff: DoctrineExtensions\Query\Mysql\TimestampDiff
                     week: DoctrineExtensions\Query\Mysql\Week
                     weekday: DoctrineExtensions\Query\Mysql\WeekDay
                     year: DoctrineExtensions\Query\Mysql\Year

                 numeric_functions:
                     acos: DoctrineExtensions\Query\Mysql\Acos
                     asin: DoctrineExtensions\Query\Mysql\Asin
                     atan2: DoctrineExtensions\Query\Mysql\Atan2
                     atan: DoctrineExtensions\Query\Mysql\Atan
                     cos: DoctrineExtensions\Query\Mysql\Cos
                     cot: DoctrineExtensions\Query\Mysql\Cot
                     hour: DoctrineExtensions\Query\Mysql\Hour
                     pi: DoctrineExtensions\Query\Mysql\Pi
                     power: DoctrineExtensions\Query\Mysql\Power
                     quarter: DoctrineExtensions\Query\Mysql\Quarter
                     rand: DoctrineExtensions\Query\Mysql\Rand
                     round: DoctrineExtensions\Query\Mysql\Round
                     sin: DoctrineExtensions\Query\Mysql\Sin
                     std: DoctrineExtensions\Query\Mysql\Std
                     tan: DoctrineExtensions\Query\Mysql\Tan

                 string_functions:
                     binary: DoctrineExtensions\Query\Mysql\Binary
                     char_length: DoctrineExtensions\Query\Mysql\CharLength
                     concat_ws: DoctrineExtensions\Query\Mysql\ConcatWs
                     countif: DoctrineExtensions\Query\Mysql\CountIf
                     crc32: DoctrineExtensions\Query\Mysql\Crc32
                     degrees: DoctrineExtensions\Query\Mysql\Degrees
                     field: DoctrineExtensions\Query\Mysql\Field
                     find_in_set: DoctrineExtensions\Query\Mysql\FindInSet
                     group_concat: DoctrineExtensions\Query\Mysql\GroupConcat
                     ifelse: DoctrineExtensions\Query\Mysql\IfElse
                     ifnull: DoctrineExtensions\Query\Mysql\IfNull
                     match_against: DoctrineExtensions\Query\Mysql\MatchAgainst
                     md5: DoctrineExtensions\Query\Mysql\Md5
                     month: DoctrineExtensions\Query\Mysql\Month
                     monthname: DoctrineExtensions\Query\Mysql\MonthName
                     nullif: DoctrineExtensions\Query\Mysql\NullIf
                     radians: DoctrineExtensions\Query\Mysql\Radians
                     regexp: DoctrineExtensions\Query\Mysql\Regexp
                     replace: DoctrineExtensions\Query\Mysql\Replace
                     sha1: DoctrineExtensions\Query\Mysql\Sha1
                     sha2: DoctrineExtensions\Query\Mysql\Sha2
                     soundex: DoctrineExtensions\Query\Mysql\Soundex
                     uuid_short: DoctrineExtensions\Query\Mysql\UuidShort

There may be more functions available than this, check
[lib/DoctrineExtensions/Query/Mysql](lib/DoctrineExtensions/Query/Mysql)
to be sure.


Legacy versions
---------------

If you're still using Paginator, LargeCollections, Phing, PHPUnit or Versionable
behaviours available in `0.1`–`0.3`, you're welcome to use `0.3` – but do note,
**this functionality is now available in Doctrine core, no longer supported in
this library, and was removed in 1.0**.

Whilst pull requests for bugfixes to this functionality will be considered for
0.x releases, you are encouraged to switch out your implementations and upgrade
to ~1.0.


## Including DoctrineExtensions

To include the DoctrineExtensions you should fire up an autoloader, for example:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
$classLoader->register();
```


## Paginator (deprecated)

The paginator offers a powerful way to iterate over any DQL, even fetch joins of collections. For this it has to issue
3 queries to the database:

1. Count the total number of entries in the list
2. Fetch the Unique IDs of the given $limit + $offset window
3. Fetch the Entities for all the Unique Ids given in 2.

If you don't need to iterate a fetch-joined to-many DQL query you can shortcut:

1. Count the total number of entries in the list
2. Fetch the Query using $query->setFirstResult($offset)->setMaxResults($limit);

The API for the Paginator is really simple:

```php
<?php

use DoctrineExtensions\Paginate\Paginate;

$query = $em->createQuery($dql);

$count = Paginate::getTotalQueryResults($query); // Step 1
$paginateQuery = Paginate::getPaginateQuery($query, $offset, $limitPerPage); // Step 2 and 3
$result = $paginateQuery->getResult();
```

In the simple case its even easier:

```php
<?php

$count = Paginate::getTotalQueryResults($query); // Step 1
$result = $query->setFirstResult($offset)->setMaxResults($limitPerPage)->getResult(); // Step 2
```

These methods internally use several others to create and retrieve the data. You can re-use
those methods to integrate with existing pagination solutions, a `Zend_Paginator` implementation
is already shipped (`DoctrineExtensions\Paginate\PaginationAdapter`).

## Phing (deprecated)

There are currently two Phing tasks provided by DoctrineExtensions:

### GenerateProxies

Generates Doctrine 2 proxy files.

```xml
<!-- assuming you have included the class file first -->

<taskdef classname="DoctrineExtensions\Phing\Task\GenerateProxies" name="d2-proxies" />

<d2-proxies cliConfig="${somedir}/cli-config.php" />
```

### InstallSql

Generates a valid PHP file containing an array with all SQL that would be
installed.

```xml
<!-- assuming you have included the class file first -->

<taskdef classname="DoctrineExtensions\Phing\Task\InstallSql" name="d2-install-sql" />

<d2-install-sql installSqlFile="${somedir}/sql/schema.sql.php" />
```

## PHPUnit (deprecated)

The PHPUnit Extension for Doctrine offers several hooks into PHPUnits Database extension and offers a
very convenient way to test your Doctrine 2 code against a Database.

### Using the OrmTestCase:

#### An Example

```php
<?php

namespace MyProject\Tests;

use DoctrineExtensions\PHPUnit\OrmTestCase

class EntityFunctionalTest extends OrmTestCase
{
    protected function createEntityManager()
    {
        return Doctrine\ORM\EntityManager::create(..);
    }

    protected function getDataSet()
    {
        return $this->createFlatXmlDataSet(__DIR__."/_files/entityFixture.xml");
    }
}
```

For more information see the PHPUnit Documentation on this topic: http://www.phpunit.de/manual/current/en/database.html

#### Notes

This PHPUnit extension does not create the database schema for you. It has to be created before you run the tests.
If you want to dynamically create the schema you have to listen to the 'preTestSetUp' and 'postTestSetUp' events
that are called before and after the fixture is loaded respectively.

```php
<?php

namespace MyProject\Tests;

use DoctrineExtensions\PHPUnit\Event\EntityManagerEventArgs,
    DoctrineExtensions\PHPUnit\OrmTestCase,
    Doctrine\ORM\Tools\SchemaTool,
    Doctrine\ORM\EntityManager;

class SchemaSetupListener
{
    public function preTestSetUp(EntityManagerEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();

        $schemaTool = new SchemaTool($em);

        $cmf = $em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();

        $schemaTool->dropDatabase();
        $schemaTool->createSchema($classes);
    }
}

class EntityFunctionalTest extends OrmTestCase
{
    protected function createEntityManager()
    {
        $eventManager = new EventManager();
        $eventManager->addEventListener(array("preTestSetUp"), new SchemaSetupListener());

        return Doctrine\ORM\EntityManager::create(.., $eventManager);
    }
}
```

### TODOs:

* Add a Filter to transform between Entity-Speak and database columns for the DataSet and DataTable interfaces.
  This could also be used as basis for "fixture" management. XML or YAML fixture formats could be used to
  fill the database initially.
* Add a test-case that automatically tests the persistence of all your entities against the current mapping
  schema and database, aswell as related entities.

## Versionable (deprecated)

Deprecated, please use https://github.com/simplethings/EntityAudit

### Introduction

Versionable allows you to tag your entities by the `DoctrineExtensions\Versionable\Versionable`
interface, which leads to snapshots of the entities being made upon saving to the database.

This is an extended version of the prototype discussed in a blog-post on the Doctrine 2 website:

http://www.doctrine-project.org/blog/doctrine2-versionable

The interface `Versionable` is modified considerably by removing all the `getResourceId()`, `getVersionedData()` and
`getCurrentVersion()` methods, since Doctrine can easily retrieve these values on its own using the UnitOfWork API.
Versionable is then just a marker interface.

### What Versionable does

Whenever an entity that implements Versionable is *updated* all the old values of the entity are
saved with their old version number into a newly created `ResourceVersion` entity.

### Requirements of your entities are:

* Single Identifier Column (String or Integer)
* Entity has to be versioned (using @version annotation)

Implementing `Versionable` would look like:

```php
<?php

namespace MyProject;
use DoctrineExtensions\Versionable\Versionable;

class BlogPost implements Versionable
{
    // blog post API
}
```

### Configuration

You have to add the `DoctrineExtensions\Versionable\Entity\ResourceVersion` entity to your metadata paths.
It is using the Annotation Metadata driver, so you have to specifiy or configure the path to the directory on the CLI.
Also if you are using any other metadata driver you have to wrap the `Doctrine\ORM\Mapping\Driver\DriverChain`
to allow for multiple metadata drivers.

You also have to hook the `VersionListener` into the EntityManager's EventManager explicitly upon
construction:

```php
<?php

$eventManager = new EventManager();
$eventManager->addEventSubscriber(new VersionListener());
$em = EntityManager::create($connOptions, $config, $eventManager);
```

Using the `VersionManager` you can now retrieve all the versions of a versionable entity:

```php
<?php

$versionManager = new VersionManager($em);
$versions = $versionManager->getVersions($blogPost);
```

Or you can revert to a specific version number:

```php
<?php

$versionManager = new VersionManager($em);
$versionManager->revert($blogPost, 100);
$em->flush();
```
