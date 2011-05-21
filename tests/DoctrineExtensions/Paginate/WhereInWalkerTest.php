<?php

namespace DoctrineExtensions\Paginate;

use Doctrine\ORM\Query;

class WhereInWalkerTest extends \PHPUnit_Framework_TestCase
{

    public $entityManager = null;

    public function testWhereInQuery_NoWhere()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testCountQuery_MixedResultsWithName()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT a, sum(a.name) as foo FROM DoctrineExtensions\Paginate\Author a'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT a0_.id AS id0, a0_.name AS name1, sum(a0_.name) AS sclr2 FROM Author a0_ WHERE a0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testWhereInQuery_SingleWhere()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE 1 = 1'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE 1 = 1 AND u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testWhereInQuery_MultipleWhereWithAnd()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE 1 = 1 AND 2 = 2'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE 1 = 1 AND 2 = 2 AND u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testWhereInQuery_MultipleWhereWithOr()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE 1 = 1 OR 2 = 2'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE (1 = 1 OR 2 = 2) AND u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testWhereInQuery_MultipleWhereWithMixed_1()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE (1 = 1 OR 2 = 2) AND 3 = 3'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE (1 = 1 OR 2 = 2) AND 3 = 3 AND u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testWhereInQuery_MultipleWhereWithMixed_2()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE 1 = 1 AND 2 = 2 OR 3 = 3'
        );
        $whereInQuery = clone $query;
        $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $whereInQuery->setHint('id.count', 10);

        $this->assertEquals(
                "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE (1 = 1 AND 2 = 2 OR 3 = 3) AND u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $whereInQuery->getSql()
        );
    }

    public function testCreateWhereInQuery()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE 1 = 1'
        );
        $whereInQuery = Paginate::createWhereInQuery($query, array(1, 2, 3, 4), 'pgid');

        $this->assertEquals(array('DoctrineExtensions\Paginate\WhereInWalker'), $whereInQuery->getHint(Query::HINT_CUSTOM_TREE_WALKERS));
        $this->assertEquals(4, $whereInQuery->getHint('id.count'));
        $this->assertEquals('pgid', $whereInQuery->getHint('pg.ns'));
        $this->assertEquals(1, $whereInQuery->getParameter('pgid_1'));
        $this->assertEquals(2, $whereInQuery->getParameter('pgid_2'));
        $this->assertEquals(3, $whereInQuery->getParameter('pgid_3'));
        $this->assertEquals(4, $whereInQuery->getParameter('pgid_4'));
    }

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir(__DIR__ . '/_files');
        $config->setProxyNamespace('DoctrineExtensions\Paginate\Proxies');
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver());

        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
    }

}

/** @Entity */
class Group
{

    /** @Id @column(type="integer") @generatedValue */
    public $id;
    /** @ManyToMany(targetEntity="User", mappedBy="groups") */
    public $users;
}

/** @Entity */
class User
{

    /** @Id @column(type="integer") @generatedValue */
    public $id;
    /**
     * @ManyToMany(targetEntity="Group", inversedBy="users")
     * @JoinTable(
     *  name="user_group",
     *  joinColumns = {@JoinColumn(name="user_id", referencedColumnName="id")},
     *  inverseJoinColumns = {@JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    public $groups;
}
