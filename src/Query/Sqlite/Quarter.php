<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Vincent Mariani <mariani.v@sfeir.com>
 */
class Quarter extends FunctionNode
{
    public $quarter;

    public function getSql(SqlWalker $sqlWalker)
    {
        return "CAST(((STRFTIME('%m', {$sqlWalker->walkArithmeticPrimary($this->quarter)}) + 2) / 3) as NUMBER)";
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->quarter = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
