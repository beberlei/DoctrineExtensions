<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * BinaryFunction ::= "BINARY" "(" StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/cast-functions.html#operator_binary
 *
 * @author Sarjono Mukti Aji <me@simukti.net>
 * @example SELECT BINARY(foo.bar) FROM entity
 * @example SELECT BINARY("string")
 * @example SELECT BINARY(2)
 */
class Binary extends FunctionNode
{
    /** @var Node */
    private $stringPrimary;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'BINARY(' . $sqlWalker->walkSimpleArithmeticExpression($this->stringPrimary) . ')';
    }
}
