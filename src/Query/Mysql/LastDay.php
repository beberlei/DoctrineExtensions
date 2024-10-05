<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * LastDayFunction ::= "LAST_DAY" "(" ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/8.3/en/date-and-time-functions.html#function_last-day
 *
 * @author Rafael Kassner <kassner@gmail.com>
 * @author Sarjono Mukti Aji <me@simukti.net>
 *
 * @example SELECT LAST_DAY('2023-05-06')
 * @example SELECT LAST_DAY(foo.bar) FROM entity
 */
class LastDay extends FunctionNode
{
    /** @var Node|string */
    public $date;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'LAST_DAY(' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
