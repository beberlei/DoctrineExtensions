<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\QueryException;

/**
 * Class DateSub
 *
 * @author Vas N <phpvas@gmail.com>
 */
class DateSub extends DateAdd
{
    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @throws QueryException
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
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
