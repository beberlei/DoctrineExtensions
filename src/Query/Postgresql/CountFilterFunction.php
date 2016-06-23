<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\Parser;

/**
 * CountFilterFunction ::= "COUNT_FILTER" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class CountFilterFunction extends FunctionNode
{
    public $countExpression = null;
    public $whereExpression = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->countExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->whereExpression = $parser->WhereClause();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('COUNT(%s) FILTER(%s)',
            $this->countExpression->dispatch($sqlWalker),
            $this->whereExpression->dispatch($sqlWalker)
        );
    }

}
