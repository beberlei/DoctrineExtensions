<?php

namespace DoctrineExtensions\Paginate;
use Doctrine\ORM\Query;

class Paginate
{
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
     * @return Query
     */
    static public function createCountQuery(Query $query)
    {
        /* @var $countQuery Query */
        $countQuery = clone $query;

        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\CountWalker'));
        $countQuery->setFirstResult(null)->setMaxResults(null);
        
        return $countQuery;
    }
}