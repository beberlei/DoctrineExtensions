<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * SumEqualFunction ::= "SUM_EQUAL" "(" StringPrimary "," ArithmeticPrimary ")"
 */
class SumEqual extends FunctionNode
{
    protected $stringPrimary;
    protected $stringCondition;

    /**
     * @override
     */
     public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->stringPrimary = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->stringCondition = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @override
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf("SUM(%s = %s)", $this->stringPrimary->dispatch($sqlWalker), $this->stringCondition->dispatch($sqlWalker));
    }
}
