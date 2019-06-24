<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Andrew Mackrodt <andrew@ajmm.org>
 */
class IfElse extends FunctionNode
{
    private $expr = [];

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr[] = $parser->ConditionalExpression();

        $parser->match(Lexer::T_COMMA);
        if ($parser->getLexer()->isNextToken(Lexer::T_NULL)) {
            $parser->match(Lexer::T_NULL);
            $this->expr[] = null;
        } else {
            $this->expr[] = $parser->ArithmeticExpression();
        }
        $parser->match(Lexer::T_COMMA);
        if ($parser->getLexer()->isNextToken(Lexer::T_NULL)) {
            $parser->match(Lexer::T_NULL);
            $this->expr[] = null;
        } else {
            $this->expr[] = $parser->ArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'IF(%s, %s, %s)',
            $sqlWalker->walkConditionalExpression($this->expr[0]),
            $this->expr[1] !== null ? $sqlWalker->walkArithmeticPrimary($this->expr[1]) : 'NULL',
            $this->expr[2] !== null ? $sqlWalker->walkArithmeticPrimary($this->expr[2]) : 'NULL'
        );
    }
}
