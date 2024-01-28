<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\SqlWalker;

abstract class NumberFromStrfTime extends AbstractStrfTime
{
    public function getSql(SqlWalker $sqlWalker): string
    {
        return "CAST(STRFTIME('"
                . $this->getFormat()
                . "', "
                . $sqlWalker->walkArithmeticPrimary($this->date)
            . ') AS NUMBER)';
    }
}
