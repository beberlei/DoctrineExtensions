<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class Hour extends FunctionNode
{
    private $date;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'EXTRACT(HOUR FROM %s)',
            $sqlWalker->walkArithmeticPrimary($this->date)
        );
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
