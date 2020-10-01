<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @example SELECT TIME_TO_SEC('22:23:00');
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_time-to-sec
 * @author Pawel Stasicki <p.stasicki@gmail.com>
 */
class TimeToSec extends FunctionNode
{
    public $time;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'TIME_TO_SEC('.$sqlWalker->walkArithmeticPrimary($this->time).')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
