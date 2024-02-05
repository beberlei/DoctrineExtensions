<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/** @author Giulia Santoiemma <giuliaries@gmail.com> */
class Rpad extends FunctionNode
{
    public $string = null;

    public $length = null;

    public $padstring = null;

    public function parse(Parser $parser): void
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

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'RPAD(' .
        $this->string->dispatch($sqlWalker) . ', ' .
        $this->length->dispatch($sqlWalker) . ', ' .
        $this->padstring->dispatch($sqlWalker) .
        ')';
    }
}
