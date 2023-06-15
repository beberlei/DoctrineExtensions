<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Vas N <phpvas@gmail.com>
 */
class DateSub extends DateAdd
{
    /**
     * @param SqlWalker $sqlWalker
     * @throws QueryException
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $unit = strtoupper(is_string($this->unit) ? $this->unit : $this->unit->value);

        if (!in_array($unit, self::$allowedUnits)) {
            throw QueryException::semanticalError('DATE_SUB() does not support unit "' . $unit . '".');
        }

        return 'DATE_SUB(' .
            $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
            $this->intervalExpression->dispatch($sqlWalker) . ' ' . $unit .
        ')';
    }
}
