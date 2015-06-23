<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Dawid Nowak <macdada@mmg.pl>
 */
class Hour extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%H';
    }
}
