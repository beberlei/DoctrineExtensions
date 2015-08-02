<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Andreas Gallien <gallien@seleos.de>
 */
class Sha2 extends FunctionNode
{
    public $stringPrimary;

    public $simpleArithmeticExpression;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'SHA2(' .
            $sqlWalker->walkStringPrimary($this->stringPrimary) .
            ',' .
            $sqlWalker->walkSimpleArithmeticExpression($this->simpleArithmeticExpression) .
        ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
