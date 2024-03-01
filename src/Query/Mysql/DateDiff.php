<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * DateDiffFunction ::= "DATE_DIFF" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_datediff
 *
 * @example SELECT DATE_DIFF("2024-05-06", "2024-05-07")
 * @example SELECT DATE_DIFF(foo.bar, foo.bar2) FROM entity
 */
class DateDiff extends FunctionNode
{
    /** @var Node|string */
    public $firstDateExpression = null;

    /** @var Node|string */
    public $secondDateExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->secondDateExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'DATEDIFF(' .
            $sqlWalker->walkArithmeticTerm($this->firstDateExpression) . ', ' .
            $sqlWalker->walkArithmeticTerm($this->secondDateExpression) .
        ')';
    }
}
