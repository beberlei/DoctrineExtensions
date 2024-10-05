<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * AnyValueFunction ::= "ANY_VALUE" "(" StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/miscellaneous-functions.html#function_any-value
 *
 * @example SELECT ANY_VALUE(foo.bar) FROM entity
 */
class AnyValue extends FunctionNode
{
    /** @var Node */
    public $value;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->value = $parser->StringPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'ANY_VALUE(%s)',
            $this->value->dispatch($sqlWalker)
        );
    }
}
