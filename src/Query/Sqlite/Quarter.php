<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Vincent Mariani <mariani.v@sfeir.com>
 */
class Quarter extends FunctionNode
{
    public $quarter;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "CAST(((STRFTIME('%m', {$sqlWalker->walkArithmeticPrimary($this->quarter)}) + 2) / 3) as NUMBER)";
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->quarter = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
