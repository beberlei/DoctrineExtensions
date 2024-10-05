<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * InetAtonFunction ::= "INET_ATON" "(" StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/miscellaneous-functions.html#function_inet-aton
 *
 * @example SELECT INET_ATON('127.0.0.1')
 * @example SELECT INET_ATON(foo.bar) FROM entity
 */
class InetAton extends FunctionNode
{
    /** @var Node */
    public $valueExpression = null;

    /** @throws QueryException */
    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->valueExpression = $parser->StringPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'INET_ATON('
            . (
                $this->valueExpression instanceof Node
                ? $this->valueExpression->dispatch($sqlWalker)
                : "'" . $this->valueExpression . "'"
            )
            . ')';
    }
}
