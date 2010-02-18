# Some Doctrine 2 Extensions

This package contains several extensions to Doctrine 2 that hook into the facilities of Doctrine and
offer new functionality or tools to use Doctrine 2 more efficently.

## Including DoctrineExtensions

To include the DoctrineExtensions should fire up an autoloader, for example:

    $classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', "/path/to/extensions");
    $classLoader->register();

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
        Doctrine\ORM\Tools\SchemaTool;

    class SchemaSetupListener
    {
        public function preTestSetUp(EntityManagerEventArgs $eventArgs)
        {
            $em = $eventArgs->getEntityManager();

            $schemaTool = new SchemaTool($em);

            $cmf = $em->getMetadataFactory();
            $classes = $cmf->getAllMetadata();

            $schemaTool->dropSchema($classes);
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
