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
                "SELECT COUNT(*) AS _dctrn_count FROM (SELECT DISTINCT id0 FROM (SELECT b0_.id AS id0, c1_.id AS id1, a2_.id AS id2, a2_.name AS name3, b0_.author_id AS author_id4, b0_.category_id AS category_id5 FROM BlogPost b0_ INNER JOIN Category c1_ ON b0_.category_id = c1_.id INNER JOIN Author a2_ ON b0_.author_id = a2_.id) AS _dctrn_result) AS _dctrn_table", $countQuery->getSql()
        );
    }

    public function testCountQuery_MixedResultsWithName()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT a, sum(a.name) as foo FROM DoctrineExtensions\Paginate\Author a');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT COUNT(*) AS _dctrn_count FROM (SELECT DISTINCT id0 FROM (SELECT a0_.id AS id0, a0_.name AS name1, sum(a0_.name) AS sclr2 FROM Author a0_) AS _dctrn_result) AS _dctrn_table", $countQuery->getSql()
        );
    }

    public function testCountQuery_Having()
    {
        $query = $this->entityManager->createQuery(
                        'SELECT a, p, count(p.id) AS postCount FROM DoctrineExtensions\Paginate\Author a LEFT JOIN a.posts p GROUP BY a.id HAVING postCount > 0');
        $countQuery = Paginate::createCountQuery($query);

        $this->assertEquals(
                "SELECT COUNT(*) AS _dctrn_count FROM (SELECT DISTINCT id1 FROM (SELECT count(b0_.id) AS sclr0, a1_.id AS id1, a1_.name AS name2, b0_.id AS id3, b0_.author_id AS author_id4, b0_.category_id AS category_id5 FROM Author a1_ LEFT JOIN BlogPost b0_ ON a1_.id = b0_.author_id GROUP BY a1_.id HAVING sclr0 > 0) AS _dctrn_result) AS _dctrn_table", $countQuery->getSql()
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
     * @ManyToOne(targetEntity="Author", inversedBy="posts")
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
    /** @OneToMany(targetEntity="BlogPost", mappedBy="author") */
    public $posts;
}

/**
 * @Entity
 */
class Category
{

    /** @id @column(type="integer") @generatedValue */
    public $id;

}
