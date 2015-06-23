<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Martin Štekl <martin.stekl@gmail.com>
 */
class Minute extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%M';
    }
}
