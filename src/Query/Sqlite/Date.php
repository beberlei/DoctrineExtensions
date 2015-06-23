<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Steve Lacey <steve@stevelacey.net>
 */
class Date extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%Y-%m-%d';
    }
}
