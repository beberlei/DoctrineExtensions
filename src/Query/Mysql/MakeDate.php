<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class MakeDate extends FunctionNode
{
    public $year = null;

    public $dayOfYear = null;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->year = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->dayOfYear = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'MAKEDATE(' .
            $sqlWalker->walkArithmeticPrimary($this->year) . ', ' .
            $sqlWalker->walkArithmeticPrimary($this->dayOfYear) .
            ')';
    }
}
