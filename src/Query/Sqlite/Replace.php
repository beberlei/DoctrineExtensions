<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author winkbrace <winkbrace@gmail.com>
 */
class Replace extends FunctionNode
{
    public $search = null;
    public $replace = null;
    public $subject = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->subject = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->search = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->replace = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'REPLACE(' .
            $this->subject->dispatch($sqlWalker) . ', ' .
            $this->search->dispatch($sqlWalker) . ', ' .
            $this->replace->dispatch($sqlWalker) .
        ')';
    }
}
