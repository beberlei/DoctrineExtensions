<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * JsonDepthFunction ::= "JSON_DEPTH" "(" StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/json-attribute-functions.html#function_json-depth
 *
 * @example SELECT JOIN_DEPTH(foo.bar) FROM entity
 */
class JsonDepth extends FunctionNode
{
    /** @var Node */
    protected $target;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf('JSON_DEPTH(%s)', $sqlWalker->walkStringPrimary($this->target));
    }
}
