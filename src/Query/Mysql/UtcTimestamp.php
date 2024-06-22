<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * UtcTimestampFunction ::= "UTC_TIMESTAMP" "(" ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_utc-timestamp
 *
 * @author      Marius Krämer <marius@marius-kraemer.de>
 */
class UtcTimestamp extends FunctionNode
{
    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'UTC_TIMESTAMP()';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
