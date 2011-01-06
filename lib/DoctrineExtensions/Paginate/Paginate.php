<?php

namespace DoctrineExtensions\Paginate;
use Doctrine\ORM\Query;

class Paginate
{
    /**
     * @param Query $query
     * @return Query
     */
    static protected function cloneQuery(Query $query)
    {
        /* @var $countQuery Query */
        $countQuery = clone $query;
        $params = $query->getParameters();

        foreach ($params as $key => $param) {
            $countQuery->setParameter($key, $param);
        }

        return $countQuery;
    } 

    /**
     * @param Query $query
     * @return int
     */
    static public function count(Query $query)
    {
        return self::createCountQuery($query)->getSingleScalarResult();
    }

    /**
     * @param Query $query
     * @return int
     */
    static public function getTotalQueryResults(Query $query)
    {
        return self::createCountQuery($query)->getSingleScalarResult();
    }

    /**
     * Given the Query it returns a new query that is a paginatable query using a modified subselect.
     *
     * @param Query $query
     * @return Query
     */
    static public function getPaginateQuery(Query $query, $offset, $itemCountPerPage)
    {
        $ids = array_map('current', self::createLimitSubQuery($query, $offset, $itemCountPerPage)->getScalarResult());

        return self::createWhereInQuery($query, $ids);
    }

    /**
     * @param Query $query
     * @return Query
     */
    static public function createCountQuery(Query $query)
    {
        /* @var $countQuery Query */
        $countQuery = self::cloneQuery($query);

        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\CountWalker'));
        $countQuery->setFirstResult(null)->setMaxResults(null);
        
        $countQuery->setParameters($query->getParameters());
        return $countQuery;
    }

    /**
     * @param Query $query
     * @param int $offset
     * @param int $itemCountPerPage
     * @return Query
     */
    static public function createLimitSubQuery(Query $query, $offset, $itemCountPerPage)
    {
        $subQuery = self::cloneQuery($query);
        $subQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\LimitSubqueryWalker'))
            ->setFirstResult($offset)
            ->setMaxResults($itemCountPerPage);
        $subQuery->setParameters($query->getParameters());
        return $subQuery;
    }

    /**
     * @param Query $query
     * @param array $ids
     * @param string $namespace
     * @return Query
     */
    static public function createWhereInQuery(Query $query, array $ids, $namespace = 'pgid')
    {
        // don't do this for an empty id array
        if (count($ids) > 0) {
            $whereInQuery = clone $query;
            
            $whereInQuery->setParameters($query->getParameters());
            
            $whereInQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\WhereInWalker'));
            $whereInQuery->setHint('id.count', count($ids));
            $whereInQuery->setHint('pg.ns', $namespace);
            $whereInQuery->setFirstResult(null)->setMaxResults(null);
            foreach ($ids as $i => $id) {
                $i = $i+1;
                $whereInQuery->setParameter("{$namespace}_{$i}", $id);
            }
            return $whereInQuery;
        } else {
            return $query;
        }
    }
}
