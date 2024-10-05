<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * DayNameFunction ::= "DAYNAME" "(" ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_dayname
 *
 * @author Steve Lacey <steve@steve.ly>
 * @example SELECT DAYNAME(foo.bar) FROM entity
 * @example SELECT DAYNAME('2023-05-06')
 */
class DayName extends FunctionNode
{
    /** @var Node|string */
    public $date;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'DAYNAME(' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
