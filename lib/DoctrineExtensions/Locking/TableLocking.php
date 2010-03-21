<?php
/**
 * DoctrineExtensions Locking
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Locking;

use Doctrine\Common\EventSubscriber,
    Doctrine\ORM\Events,
    Doctrine\ORM\Event\OnFlushEventArgs;

class TableLocking implements EventSubscriber
{
    private $_conn = null;

    public function getSubscribedEvents()
    {
        return array(Events::onFlush);
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $affectedTables = array();
        foreach ($uow->getScheduledEntityInsertions() AS $entity) {
            $table = $em->getClassMetadata(get_class($entity))->getTableName();
            $affectedTables[$table] = true;
        }

        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            $table = $em->getClassMetadata(get_class($entity))->getTableName();
            $affectedTables[$table] = true;
        }

        foreach ($uow->getScheduledEntityDeletions() AS $entity) {
            $table = $em->getClassMetadata(get_class($entity))->getTableName();
            $affectedTables[$table] = true;
        }

        foreach ($uow->getScheduledCollectionDeletions() AS $collection) {
            $mapping = $collection->getMapping();
            if ($mapping->isManyToMany()) {
                $affectedTables[$mapping->joinTable['name']] = true;
            }
        }

        foreach ($uow->getScheduledCollectionUpdates() AS $collection) {
            $mapping = $collection->getMapping();
            if ($mapping->isManyToMany()) {
                $affectedTables[$mapping->joinTable['name']] = true;
            }
        }

        $affectedTables = array_flip($affectedTables);

        $tablesSql = '';
        foreach ($affectedTables AS $tableName) {
            if ($tablesSql != '') {
                $tablesSql .= ', ';
            }
            $tablesSql .= $tableName.' WRITE';
        }

        $this->_conn = $em->getConnection();

        // http://dev.mysql.com/doc/refman/5.1/en/lock-tables-and-transactions.html
        $this->_conn->exec('SET autocommit = 0');
        $this->_conn->exec('LOCK TABLES '.$tablesSql);
    }

    public function unlockTables()
    {
        if ($this->_conn) {
            $this->_conn->exec('UNLOCK TABLES');
            $this->_conn = null;
        }
    }
}