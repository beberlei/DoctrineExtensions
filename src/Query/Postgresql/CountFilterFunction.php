<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * CountFilterFunction ::= "COUNT_FILTER" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class CountFilterFunction extends FunctionNode
{
    public $countExpression = null;

    public $whereExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->countExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->whereExpression = $parser->WhereClause();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'COUNT(%s) FILTER(%s)',
            $this->countExpression->dispatch($sqlWalker),
            $this->whereExpression->dispatch($sqlWalker)
        );
    }
}
