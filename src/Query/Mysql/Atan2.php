<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class Atan2 extends FunctionNode
{
    public $firstExpression;

    public $secondExpression;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $firstArgument = $sqlWalker->walkSimpleArithmeticExpression(
                        $this->firstExpression
        );

        $secondArgument = $sqlWalker->walkSimpleArithmeticExpression(
                        $this->secondExpression
        );

        return 'ATAN2(' . $firstArgument . ', ' . $secondArgument . ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_COMMA);

        $this->secondExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
