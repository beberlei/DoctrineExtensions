# Some Doctrine 2 Extensions

This package contains several extensions to Doctrine 2 that hook into the facilities of Doctrine and
offer new functionality or tools to use Doctrine 2 more efficently.

> Warning: This repository is not really maintained anymore. The important paginatior and large collections code was moved to the Doctrine2 core.
> For all the other extensions, be aware that I don't maintain them anymore.
>    
> The user-defined functions are contributed by various persons and have not always been reviewed in their quality.
> Please review everything you want to use.

## Including DoctrineExtensions

To include the DoctrineExtensions should fire up an autoloader, for example:

```php
<?php

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', "/path/to/extensions");
$classLoader->register();
```

## Paginator

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

## Phing

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

## PHPUnit

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

## Versionable

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
