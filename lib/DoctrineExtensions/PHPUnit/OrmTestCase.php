<?php
/**
 * DoctrineExtensions PHPUnit
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\PHPUnit;

use DoctrineExtensions\PHPUnit\Event\EntityManagerEventArgs;

abstract class OrmTestCase extends DatabaseTestCase
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $_em = null;

    /**
     * Performs operation returned by getSetUpOperation().
     */
    protected function setUp()
    {
        $this->databaseTester = NULL;

        $em = $this->getEntityManager();
        $eventManager = $em->getEventManager();
        if ($eventManager->hasListeners('preTestSetUp')) {
            $eventManager->dispatchEvent('preTestSetUp', new EntityManagerEventArgs($em));
        }

        $tester = $this->getDatabaseTester();

        $tester->setSetUpOperation($this->getSetUpOperation());
        $tester->setDataSet($this->getDataSet());
        $tester->onSetUp();

        if ($eventManager->hasListeners('postTestSetUp')) {
            $eventManager->dispatchEvent('postTestSetUp', new EntityManagerEventArgs($em));
        }
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    protected final function getEntityManager()
    {
        if ($this->_em == null) {
            $this->_em = $this->createEntityManager();
            $this->assertType('Doctrine\ORM\EntityManager', $this->_em,
                "Not a valid Doctrine\ORM\EntityManager returned from createEntityManager() method.");
        }
        return $this->_em;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    abstract protected function createEntityManager();

    /**
     * @return Doctrine\DBAL\Connection
     */
    final protected function getDoctrineConnection()
    {
        $em = $this->getEntityManager();
        return $em->getConnection();
    }

    /**
     * Creates a IDatabaseTester for this testCase.
     *
     * @return PHPUnit_Extensions_Database_ITester
     */
    protected function newDatabaseTester()
    {
        return new DatabaseTester($this->getConnection());
    }
}