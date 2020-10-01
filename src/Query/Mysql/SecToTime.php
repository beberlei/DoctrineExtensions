<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @example SELECT SEC_TO_TIME(2378);
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_sec-to-time
 * @author Clemens Bastian <clemens.bastian@gmail.com>
 */
class SecToTime extends FunctionNode
{
    public $time;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'SEC_TO_TIME('.$sqlWalker->walkArithmeticPrimary($this->time).')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
