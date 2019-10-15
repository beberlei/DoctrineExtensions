<?php

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\QueryException;

/**
 * @author Teresa Waldl <teresa@waldl.org>
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

        return 'DATEADD(' . $unit . ', -' . $this->intervalExpression->dispatch($sqlWalker) . ', ' . $this->firstDateExpression->dispatch($sqlWalker) . ')';
    }
}
