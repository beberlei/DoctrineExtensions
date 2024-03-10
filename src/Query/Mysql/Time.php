<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * TimeFunction ::= "TIME" "(" ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_time
 *
 * @author Steve Lacey <steve@steve.ly>
 * @author James Rohacik <rohacik.james@gmail.com>
 */
class Time extends FunctionNode
{
    public $time;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'TIME(' . $sqlWalker->walkArithmeticPrimary($this->time) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
