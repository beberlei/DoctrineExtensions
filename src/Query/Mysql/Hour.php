<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * HourFunction ::= "HOUR" "(" ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/8.0/en/date-and-time-functions.html#function_hour
 *
 * @author Dawid Nowak <macdada@mmg.pl>
 *
 * @example SELECT HOUR('12:50:15')
 * @example SELECT HOUR(foo.bar) FROM entity
 */
class Hour extends FunctionNode
{
    /** @var Node|string */
    public $date;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'HOUR(' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
