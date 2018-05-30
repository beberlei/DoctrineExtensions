<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Giulia Santoiemma <giuliaries@gmail.com>
 */
class Lpad extends FunctionNode
{
    public $string = null;

    public $length = null;

    public $padstring = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->string = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->length = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->padstring = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'LPAD(' .
        $this->string->dispatch($sqlWalker) . ', ' .
        $this->length->dispatch($sqlWalker) . ', ' .
        $this->padstring->dispatch($sqlWalker) .
        ')';
    }
}
