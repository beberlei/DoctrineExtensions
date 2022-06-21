<?php

namespace DoctrineExtensions\Query\Sqlite;

abstract class NumberFromStrfTime extends AbstractStrfTime
{
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return "CAST(STRFTIME('"
                . $this->getFormat()
                . "', "
                . $sqlWalker->walkArithmeticPrimary($this->date)
            . ') AS NUMBER)';
    }
}
