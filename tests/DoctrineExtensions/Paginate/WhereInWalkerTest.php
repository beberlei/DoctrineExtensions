<?php

namespace DoctrineExtensions\Paginate;
use Doctrine\ORM\Query;

class WhereInWalkerTest extends \PHPUnit_Framework_TestCase
{
    public $entityManager = null;

    public function testWhereInQuery()
    {
        $query = $this->entityManager->createQuery(
            'SELECT u, g FROM DoctrineExtensions\Paginate\User u JOIN u.groups g WHERE 1 = 1'
        );
        $countQuery = clone $query;
        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
        $countQuery->setHint('id.count', 10);

        $this->assertEquals(
            "SELECT u0_.id AS id0, g1_.id AS id1 FROM User u0_ INNER JOIN user_group u2_ ON u0_.id = u2_.user_id INNER JOIN Group g1_ ON g1_.id = u2_.group_id WHERE u0_.id IN (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            $countQuery->getSql()
        );
    }

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir(__DIR__ . '/_files');
        $config->setProxyNamespace('DoctrineExtensions\Paginate\Proxies');

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