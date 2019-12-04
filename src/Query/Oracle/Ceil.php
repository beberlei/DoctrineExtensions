<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Jefferson Vantuir <jefferson.behling@gmail.com>
 */
class Ceil extends FunctionNode
{
    private $number;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'CEIL(%s)',
            $sqlWalker->walkArithmeticPrimary($this->number)
        );
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->number = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
