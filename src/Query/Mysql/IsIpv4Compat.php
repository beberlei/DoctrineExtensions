<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * IsIpv4CompatFunction ::= "IS_IPV4_COMPAT" "(" StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/miscellaneous-functions.html#function_is-ipv4-compat
 *
 * @example SELECT IS_IPV4_COMPAT(INET6_ATON('::127.0.0.1'))
 * @example SELECT IS_IPV4_COMPAT(foo.bar) FROM entity
 */
class IsIpv4Compat extends FunctionNode
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
        return 'IS_IPV4_COMPAT('
            . (
                $this->valueExpression instanceof Node
                ? $this->valueExpression->dispatch($sqlWalker)
                : "'" . $this->valueExpression . "'"
            )
            . ')';
    }
}
