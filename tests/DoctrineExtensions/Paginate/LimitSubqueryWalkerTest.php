<?php

namespace DoctrineExtensions\Paginate;

use Doctrine\ORM\Query;

class LimitSubqueryWalkerTest extends \PHPUnit_Framework_TestCase
{

    public $entityManager = null;

    public function testLimitSubquery()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT p, c, a FROM DoctrineExtensions\Paginate\MyBlogPost p JOIN p.category c JOIN p.author a');
        $limitQuery = clone $query;
        $limitQuery->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'DoctrineExtensions\Paginate\LimitSubqueryWalker');

        $this->assertEquals(
                "SELECT DISTINCT id0 FROM (SELECT m0_.id AS id0, c1_.id AS id1, a2_.id AS id2, a2_.name AS name3, m0_.author_id AS author_id4, m0_.category_id AS category_id5 FROM MyBlogPost m0_ INNER JOIN Category c1_ ON m0_.category_id = c1_.id INNER JOIN Author a2_ ON m0_.author_id = a2_.id) AS _dctrn_result", $limitQuery->getSql()
        );
    }

    public function testCountQuery_MixedResultsWithName()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT a, sum(a.name) as foo FROM DoctrineExtensions\Paginate\Author a');
        $limitQuery = clone $query;
        $limitQuery->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'DoctrineExtensions\Paginate\LimitSubqueryWalker');

        $this->assertEquals(
                "SELECT DISTINCT id0 FROM (SELECT a0_.id AS id0, a0_.name AS name1, sum(a0_.name) AS sclr2 FROM Author a0_) AS _dctrn_result", $limitQuery->getSql()
        );
    }

    public function testCreateLimitSubQuery()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT p, c, a FROM DoctrineExtensions\Paginate\MyBlogPost p JOIN p.category c JOIN p.author a');
        $limitQuery = Paginate::createLimitSubQuery($query, 10, 20);

        $this->assertEquals(10, $limitQuery->getFirstResult());
        $this->assertEquals(20, $limitQuery->getMaxResults());
        $this->assertEquals('DoctrineExtensions\Paginate\LimitSubqueryWalker', $limitQuery->getHint(Query::HINT_CUSTOM_OUTPUT_WALKER));
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

/**
 * @Entity
 */
class MyBlogPost
{

    /** @Id @column(type="integer") @generatedValue */
    public $id;
    /**
     * @ManyToOne(targetEntity="Author")
     */
    public $author;
    /**
     * @ManyToOne(targetEntity="Category")
     */
    public $category;
}

/**
 * @Entity
 */
class MyAuthor
{

    /** @Id @column(type="integer") @generatedValue */
    public $id;

}

/**
 * @Entity
 */
class MyCategory
{

    /** @id @column(type="integer") @generatedValue */
    public $id;

}
