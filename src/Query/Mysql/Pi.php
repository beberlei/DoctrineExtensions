<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * "PI" "(" ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/mathematical-functions.html#function_pi
 *
 * @example
 */
class Pi extends FunctionNode
{
    public $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'PI()';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
