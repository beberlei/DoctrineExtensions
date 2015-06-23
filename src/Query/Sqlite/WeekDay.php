<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;
use DoctrineExtensions\Query\Sqlite\AbstractStrfTime;

/**
 * @author Pavlo Cherniavskyi <ionafan2@gmail.com>
 */
class WeekDay extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%w';
    }
}
