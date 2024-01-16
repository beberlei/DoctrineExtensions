<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

class JsonLength extends FunctionNode
{
    protected $target;

    protected $path;

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
