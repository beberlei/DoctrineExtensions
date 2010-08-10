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

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\PersistentCollection,
    Doctrine\Common\Collections\Collection;

class LargeCollection
{
    private $reflField = null;

    public function __construct()
    {
        $rc = new \ReflectionClass('Doctrine\ORM\PersistentCollection');
        $this->reflField = $rc->getProperty('em');
        $this->reflField->setAccessible(true);
    }

    /**
     * @param  PersistentCollection $collection
     * @return EntityManager
     */
    private function getEntityManager(PersistentCollection $collection)
    {
        return $this->reflField->getValue($collection);
    }

    /**
     * @param Collection $collection
     * @return int
     */
    public function count(Collection $collection)
    {
        if ($collection instanceof PersistentCollection && !$collection->isInitialized()) {

            $em = $this->getEntityManager($collection);

            $assoc = $collection->getMapping();
            $sourceMetadata = $em->getClassMetadata($assoc['sourceEntity']);
            $targetMetadata = $em->getClassMetadata($assoc['targetEntity']);

            if (!count($targetMetadata->identifier) == 1) {
                throw new \UnexpectedValueException("Only Relations with Entities using Single Primary Keys are supported.");
            }

            $dql = 'SELECT COUNT(r.' . $targetMetadata->identifier[0] . ') AS collectionCount '.
                   'FROM ' . $sourceMetadata->name . ' o LEFT JOIN o.' . $assoc['fieldName'] . ' r ' .
                   'WHERE ' . $this->getWhereConditions($sourceMetadata);
            $query = $em->createQuery($dql);

            $this->setParameters($collection, $query);
            return $query->getSingleScalarResult();
        } else {
            return count($collection);
        }
    }

    /**
     * Return the slice from any given collection, using optimized queries for unitialized PersistentCollections.
     * 
     * @param Collection $collection
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getSlice(Collection $collection, $limit, $offset = 0)
    {
        if ($collection instanceof PersistentCollection && !$collection->isInitialized()) {
            return $this->getSliceQuery($collection, $limit, $offset)->getResult();
        } else {
            $col = $collection->toArray();

            return \array_slice($col, $offset, $limit);
        }
    }

    /**
     * Return a Query instance to retrieve a slice of the given limit and offset from a persistent collection.
     *
     * @param PersistentCollection $collection
     * @param int $limit
     * @param int $offset
     * @return \Doctrine\ORM\Query
     */
    public function getSliceQuery(PersistentCollection $collection, $limit, $offset = 0)
    {
        $em = $this->getEntityManager($collection);

        $assoc = $collection->getMapping();
        $sourceMetadata = $em->getClassMetadata($assoc['sourceEntity']);
        $targetMetadata = $em->getClassMetadata($assoc['targetEntity']);

        if ($assoc['isOwningSide'] && !$assoc['inversedBy']) {
            throw new \UnexpectedValueException("Only bi-directional collections can be sliced.");
        }

        if ($assoc['isOwningSide']) {
            $assocField = $assoc['inversedBy'];
        } else {
            $assocField = $assoc['mappedBy'];
        }

        $dql = 'SELECT r FROM ' . $targetMetadata->name . ' r JOIN r.' . $assocField . ' o '.
               'WHERE ' . $this->getWhereConditions($sourceMetadata);
        $query = $em->createQuery($dql);

        $this->setParameters($collection, $query);
        $query->setFirstResult($offset)->setMaxResults($limit);

        return $query;
    }

    private function getWhereConditions($sourceMetadata)
    {
        $i = 0;
        $whereConditions = array_map(function($fieldName) use(&$i) {
            return 'o.' . $fieldName . ' = ?' . ++$i;
        }, $sourceMetadata->identifier);
        return implode(" AND ", $whereConditions);
    }

    private function setParameters($collection, $query)
    {
        $em = $this->getEntityManager($collection);

        $i = 0;
        foreach ($em->getUnitOfWork()->getEntityIdentifier($collection->getOwner()) AS $value) {
            $query->setParameter(++$i, $value);
        }
    }
}
