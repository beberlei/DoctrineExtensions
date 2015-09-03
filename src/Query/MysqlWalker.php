<?php

namespace DoctrineExtensions\Query;

use Doctrine\ORM\Query\SqlWalker;

class MysqlWalker extends SqlWalker
{
    /** {@inheritDoc} */
    public function walkSelectClause($selectClause)
    {
        $sql = parent::walkSelectClause($selectClause);

        // Gets the query
        $query = $this->getQuery();

        if ($query->getHint('mysqlWalker.sqlCalcFoundRows') === true) {
            // Appends the SQL_CALC_FOUND_ROWS modifier
            $sql = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
        }

        if ($query->getHint('mysqlWalker.sqlNoCache') === true) {
            // Appends the SQL_NO_CACHE modifier
            $sql = str_replace('SELECT', 'SELECT SQL_NO_CACHE', $sql);
        }

        return $sql;
    }

    /** {@inheritDoc} */
    public function walkGroupByClause($groupByClause)
    {
        $sql = parent::walkGroupByClause($groupByClause);

        // Gets the query
        $query = $this->getQuery();

        if ($query->getHint('mysqlWalker.withRollup') === true) {
            // Appends the WITH ROLLUP modifier
            $sql .= ' WITH ROLLUP';
        }

        return $sql;
    }
}
