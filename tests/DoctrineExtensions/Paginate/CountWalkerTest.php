<?php

namespace DoctrineExtensions\Paginate;

use Doctrine\ORM\Query;

class CountWalkerTest extends \PHPUnit_Framework_TestCase
{

    public $entityManager = null;

    public function testCountQuery()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT p, c, a FROM DoctrineExtensions\Paginate\BlogPost p JOIN p.category c JOIN p.author a');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT count(DISTINCT b0_.id) AS sclr0 FROM BlogPost b0_ INNER JOIN Category c1_ ON b0_.category_id = c1_.id INNER JOIN Author a2_ ON b0_.author_id = a2_.id", $countQuery->getSql()
        );
    }

    public function testCountQuery_MixedResultsWithName()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT a, sum(a.name) as foo FROM DoctrineExtensions\Paginate\Author a');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT count(DISTINCT a0_.id) AS sclr0 FROM Author a0_", $countQuery->getSql()
        );
    }

    public function testCountQuery_RemovesGroupBy()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT b FROM DoctrineExtensions\Paginate\BlogPost b GROUP BY b.id');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT count(DISTINCT b0_.id) AS sclr0 FROM BlogPost b0_", $countQuery->getSql()
        );
    }

    public function testCountQuery_RemovesOrderBy()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT p, c, a FROM DoctrineExtensions\Paginate\BlogPost p JOIN p.category c JOIN p.author a ORDER BY a.name');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT count(DISTINCT b0_.id) AS sclr0 FROM BlogPost b0_ INNER JOIN Category c1_ ON b0_.category_id = c1_.id INNER JOIN Author a2_ ON b0_.author_id = a2_.id", $countQuery->getSql()
        );
    }

    public function testCountQuery_RemovesLimits()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT p, c, a FROM DoctrineExtensions\Paginate\BlogPost p JOIN p.category c JOIN p.author a');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT count(DISTINCT b0_.id) AS sclr0 FROM BlogPost b0_ INNER JOIN Category c1_ ON b0_.category_id = c1_.id INNER JOIN Author a2_ ON b0_.author_id = a2_.id", $countQuery->getSql()
        );
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
class BlogPost
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
class Author
{

    /** @Id @column(type="integer") @generatedValue */
    public $id;
    /** @Column(type="string") */
    public $name;

}

/**
 * @Entity
 */
class Category
{

    /** @id @column(type="integer") @generatedValue */
    public $id;

}
