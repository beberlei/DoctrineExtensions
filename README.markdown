# Some Doctrine 2 Extensions

This package contains several extensions to Doctrine 2 that hook into the facilities of Doctrine and
offer new functionality or tools to use Doctrine 2 more efficently.

## Including DoctrineExtensions

To include the DoctrineExtensions should fire up an autoloader, for example:

    $classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', "/path/to/extensions");
    $classLoader->register();

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

    use DoctrineExtensions\Paginate\Paginate;

    $query = $em->createQuery($dql);

    $count = Paginate::getTotalQueryResults($query); // Step 1
    $paginateQuery = Paginate::getPaginateQuery($query, $offset, $limitPerPage); // Step 2 and 3
    $result = $paginateQuery->getResult();

In the simple case its even easier:

    $count = Paginate::getTotalQueryResults($query); // Step 1
    $result = $query->setFirstResult($offset)->setMaxResults($limitPerPage)->getResult(); // Step 2

These methods internally use several others to create and retrieve the data. You can re-use
those methods to integrate with existing pagination solutions, a `Zend_Paginator` implementation
is already shipped (`DoctrineExtensions\Paginate\PaginationAdapter`).

## PHPUnit

The PHPUnit Extension for Doctrine offers several hooks into PHPUnits Database extension and offers a
very convenient way to test your Doctrine 2 code against a Database.

### Using the OrmTestCase:

#### An Example

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

For more information see the PHPUnit Documentation on this topic: http://www.phpunit.de/manual/current/en/database.html

#### Notes

This PHPUnit extension does not create the database schema for you. It has to be created before you run the tests.
If you want to dynamically create the schema you have to listen to the 'preTestSetUp' and 'postTestSetUp' events
that are called before and after the fixture is loaded respectively.

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

### TODOs:

* Add a Filter to transform between Entity-Speak and database columns for the DataSet and DataTable interfaces.
  This could also be used as basis for "fixture" management. XML or YAML fixture formats could be used to
  fill the database initially.
* Add a test-case that automatically tests the persistence of all your entities against the current mapping
  schema and database, aswell as related entities.

## Versionable

Deprecated, please use https://github.com/simplethings/EntityAudit