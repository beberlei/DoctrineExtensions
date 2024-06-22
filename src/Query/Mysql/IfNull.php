<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * IfNullFunction ::= "IFNULL" "(" ArithmeticExpression "," ArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/flow-control-functions.html#function_ifnull
 *
 * @author Andrew Mackrodt <andrew@ajmm.org>
 *
 * @example SELECT IFNULL(null, 2)
 * @example SELECT IFNULL(foo.bar, 1) FROM entity
 */
class IfNull extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $expr1;

    /** @var ArithmeticExpression */
    private $expr2;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'IFNULL('
            . $sqlWalker->walkArithmeticPrimary($this->expr1) . ', '
            . $sqlWalker->walkArithmeticPrimary($this->expr2) . ')';
    }
}
