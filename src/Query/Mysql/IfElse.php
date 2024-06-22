<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * IfElseFunction ::= "IFELSE" "(" ConditionalExpression "," ArithmeticExpression "," ArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/flow-control-functions.html#function_if
 *
 * @author Andrew Mackrodt <andrew@ajmm.org>
 *
 * @example SELECT IFELSE(foo.bar > 2, 1, 0) FROM entity
 * @example SELECT IFELSE(true, 0, 1)
 */
class IfElse extends FunctionNode
{
    /** @var array<AST\ConditionalExpression|AST\ConditionalFactor|AST\ConditionalPrimary|AST\ConditionalTerm|AST\ArithmeticExpression|null> */
    private $expr = [];

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr[] = $parser->ConditionalExpression();

        $parser->match(TokenType::T_COMMA);
        if ($parser->getLexer()->isNextToken(TokenType::T_NULL)) {
            $parser->match(TokenType::T_NULL);
            $this->expr[] = null;
        } else {
            $this->expr[] = $parser->ArithmeticExpression();
        }

        $parser->match(TokenType::T_COMMA);
        if ($parser->getLexer()->isNextToken(TokenType::T_NULL)) {
            $parser->match(TokenType::T_NULL);
            $this->expr[] = null;
        } else {
            $this->expr[] = $parser->ArithmeticExpression();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'IF(%s, %s, %s)',
            $sqlWalker->walkConditionalExpression($this->expr[0]),
            $this->expr[1] !== null ? $sqlWalker->walkArithmeticPrimary($this->expr[1]) : 'NULL',
            $this->expr[2] !== null ? $sqlWalker->walkArithmeticPrimary($this->expr[2]) : 'NULL'
        );
    }
}
