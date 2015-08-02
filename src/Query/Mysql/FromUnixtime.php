<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\Parser;

/**
 * @author Nima S <nimasdj@yahoo.com>
 */
class FromUnixtime extends FunctionNode
{
    public $date;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "FROM_UNIXTIME(" . $sqlWalker->walkArithmeticPrimary($this->date) . ")";
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
