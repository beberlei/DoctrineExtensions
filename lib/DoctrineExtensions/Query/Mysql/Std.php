<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "STD" "(" SimpleArithmeticExpression ")"
 *
 * @author Toni Uebernickel <tuebernickel@gmail.com>
 * @license MIT License
 */
class Std extends FunctionNode
{
    public $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('STD(%s)', $sqlWalker->walkSimpleArithmeticExpression($this->arithmeticExpression));
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
