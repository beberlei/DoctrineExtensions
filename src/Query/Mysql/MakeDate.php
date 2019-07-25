<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class MakeDate extends FunctionNode
{
    public $year      = null;

    public $dayOfYear = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->year = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->dayOfYear = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'MAKEDATE('.
            $sqlWalker->walkArithmeticPrimary($this->year).', '.
            $sqlWalker->walkArithmeticPrimary($this->dayOfYear).
            ')';
    }
}
