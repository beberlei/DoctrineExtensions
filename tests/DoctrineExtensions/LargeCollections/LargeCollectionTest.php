<?php
/*
 * Doctrine Large Collections
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\LargeCollections;

use Doctrine\Common\Util\Debug;

class LargeCollectionTest extends \PHPUnit_Framework_TestCase
{
    private $articleId;

    public function testCountOneToMany()
    {
        $lc = new LargeCollection();
        $article = $this->em->find('DoctrineExtensions\LargeCollections\Article', $this->articleId);

        $this->assertEquals(2, $lc->count($article->getComments()));
    }

    public function testCountManyToMany()
    {
        $lc = new LargeCollection();
        $article = $this->em->find('DoctrineExtensions\LargeCollections\Article', $this->articleId);

        $this->assertEquals(2, $lc->count($article->getTags()));
    }

    public function testGetSliceOneToMany()
    {
        $lc = new LargeCollection();
        $article = $this->em->find('DoctrineExtensions\LargeCollections\Article', $this->articleId);

        $results = $lc->getSliceQuery($article->getComments(), 10)->getResult();
        $this->assertEquals(2, count($results));
        $this->assertContainsOnly('DoctrineExtensions\LargeCollections\Comment', $results);

        $results = $lc->getSliceQuery($article->getComments(), 1)->getResult();
        $this->assertEquals(1, count($results));

        $results = $lc->getSliceQuery($article->getComments(), 0)->getResult();
        $this->assertEquals(0, count($results));
    }

    public function testGetSliceManyToMany()
    {
        $lc = new LargeCollection();
        $article = $this->em->find('DoctrineExtensions\LargeCollections\Article', $this->articleId);

        $results = $lc->getSliceQuery($article->getTags(), 10)->getResult();
        $this->assertEquals(2, count($results));
        $this->assertContainsOnly('DoctrineExtensions\LargeCollections\Tag', $results);

        $results = $lc->getSliceQuery($article->getTags(), 1)->getResult();
        $this->assertEquals(1, count($results));

        $results = $lc->getSliceQuery($article->getTags(), 0)->getResult();
        $this->assertEquals(0, count($results));
    }

    /**
     * @var EntityManager
     */
    private $em = null;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setProxyDir(__DIR__ . '/_files');
        $config->setProxyNamespace('DoctrineExtensions\LargeCollections\Proxies');
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver());

        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        #$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());

        $this->em = \Doctrine\ORM\EntityManager::create($conn, $config);

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $schemaTool->createSchema(array(
            $this->em->getClassMetadata('DoctrineExtensions\LargeCollections\Article'),
            $this->em->getClassMetadata('DoctrineExtensions\LargeCollections\Tag'),
            $this->em->getClassMetadata('DoctrineExtensions\LargeCollections\Comment'),
        ));

        $article = new Article();
        $tag1 = new Tag();
        $tag2 = new Tag();
        $comment1 = new Comment();
        $comment2 = new Comment();
        
        $article->addComment($comment1);
        $article->addComment($comment2);
        $article->addTag($tag1);
        $article->addTag($tag2);

        $this->em->persist($article);
        $this->em->persist($tag1);
        $this->em->persist($tag2);
        $this->em->persist($comment1);
        $this->em->persist($comment2);
        $this->em->flush();
        $this->articleId = $article->id();
        $this->em->clear();
    }
}

/**
 * @Entity
 */
class Article
{
    /** @Id @GeneratedValue @Column(type="integer") */
    private $id;

    /**
     * @OneToMany(targetEntity="Comment", mappedBy="article")
     */
    private $comments;

    /**
     * @ManyToMany(targetEntity="Tag", inversedBy="articles")
     */
    private $tags;

    public function id()
    {
        return $this->id;
    }

    public function addComment(Comment $comment)
    {
        $comment->setArticle($this);
        $this->comments[] = $comment;
    }

    public function addTag($tag)
    {
        $tag->addArticle($this);
        $this->tags[] = $tag;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getTags()
    {
        return $this->tags;
    }
}

/**
 * @Entity
 */
class Comment
{
    /** @Id @GeneratedValue @Column(type="integer") */
    private $id;

    /**
     * @ManyToOne(targetEntity="Article", inversedBy="comments")
     */
    private $article;

    public function setArticle($article)
    {
        $this->article = $article;
    }

    public function id()
    {
        return $this->id;
    }
}

/**
 * @Entity
 */
class Tag
{
    /** @Id @GeneratedValue @Column(type="integer") */
    private $id;

    /**
     * @ManyToMany(targetEntity="Article", mappedBy="tags")
     */
    private $articles;

    public function addArticle($article)
    {
        $this->articles[] = $article;
    }
}