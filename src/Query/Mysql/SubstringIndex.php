<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Vas N <phpvas@gmail.com>
 */

class SubstringIndex extends FunctionNode
{
    public $string = null;
    public $delimiter = null;
    public $count = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->string = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->delimiter = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->count = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'SUBSTRING_INDEX(' .
            $this->string->dispatch($sqlWalker) . ', ' .
            $this->delimiter->dispatch($sqlWalker) . ', ' .
            $this->count->dispatch($sqlWalker) .
        ')';
    }
}
