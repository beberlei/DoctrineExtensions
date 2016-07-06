<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * @author Cédric Bertolini <bertolini.cedric@me.com>
 */
class ToChar extends FunctionNode
{
    private $datetime;
    private $fmt;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
                'TO_CHAR(%s, %s)',
                $sqlWalker->walkArithmeticPrimary($this->datetime),
                $sqlWalker->walkArithmeticPrimary($this->fmt));
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->datetime = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->fmt = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
