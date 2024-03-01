<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * NowFunction ::= "NOW" "(" ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_now
 *
 * @example
 */
class Now extends FunctionNode
{
    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'NOW()';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
