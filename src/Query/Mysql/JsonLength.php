<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * JsonLengthFunction ::= "JSON_LENGTH" "(" StringPrimary ["," StringPrimary] ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/json-attribute-functions.html#function_json-length
 *
 * @example SELECT JSON_LENGTH(foo.bar, '$.low') FROM entity
 */
class JsonLength extends FunctionNode
{
    /** @var Node */
    protected $target;

    /** @var Node|null */
    protected $path = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        if ($parser->getLexer()->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);

            $this->path = $parser->StringPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $target = $sqlWalker->walkStringPrimary($this->target);

        if ($this->path !== null) {
            $path = $sqlWalker->walkStringPrimary($this->path);

            return sprintf('JSON_LENGTH(%s, %s)', $target, $path);
        }

        return sprintf('JSON_LENGTH(%s)', $target);
    }
}
