<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 */
class Year extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%Y';
    }
}
