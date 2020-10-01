<?php

namespace DoctrineExtensions\Query;

use Doctrine\ORM\Query\SqlWalker;

class MysqlWalker extends SqlWalker
{
    /**
     * @inheritdoc
     */
    public function walkSelectClause($selectClause)
    {
        $sql = parent::walkSelectClause($selectClause);

        $query = $this->getQuery();

        if ($query->getHint('mysqlWalker.sqlCalcFoundRows') === true) {
            $sql = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
        }

        if ($query->getHint('mysqlWalker.sqlNoCache') === true) {
            $sql = str_replace('SELECT', 'SELECT SQL_NO_CACHE', $sql);
        }

        return $sql;
    }

    /**
     * @inheritdoc
     */
    public function walkGroupByClause($groupByClause)
    {
        $sql = parent::walkGroupByClause($groupByClause);

        $query = $this->getQuery();

        if ($query->getHint('mysqlWalker.withRollup') === true) {
            $sql .= ' WITH ROLLUP';
        }

        return $sql;
    }
}
