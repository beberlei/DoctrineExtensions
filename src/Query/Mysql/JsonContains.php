<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

class JsonContains extends FunctionNode
{
    protected $target;

    protected $candidate;

    protected $path;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->candidate = $parser->StringPrimary();

        if ($parser->getLexer()->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);

            $this->path = $parser->StringPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $target    = $sqlWalker->walkStringPrimary($this->target);
        $candidate = $sqlWalker->walkStringPrimary($this->candidate);

        if ($this->path !== null) {
            $path = $sqlWalker->walkStringPrimary($this->path);

            return sprintf('JSON_CONTAINS(%s, %s, %s)', $target, $candidate, $path);
        }

        return sprintf('JSON_CONTAINS(%s, %s)', $target, $candidate);
    }
}
