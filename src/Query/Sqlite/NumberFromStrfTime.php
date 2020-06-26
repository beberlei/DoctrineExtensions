<?php

namespace DoctrineExtensions\Query\Sqlite;

abstract class NumberFromStrfTime extends AbstractStrfTime
{
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "CAST(STRFTIME('"
                . $this->getFormat()
                . "', "
                . $sqlWalker->walkArithmeticPrimary($this->date)
            . ') AS NUMBER)';
    }
}
