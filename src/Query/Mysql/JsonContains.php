<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class JsonContains extends FunctionNode
{
    protected $target;

    protected $candidate;

    protected $path;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->candidate = $parser->StringPrimary();

        if ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);

            $this->path = $parser->StringPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $target = $sqlWalker->walkStringPrimary($this->target);
        $candidate = $sqlWalker->walkStringPrimary($this->candidate);

        if ($this->path !== null) {
            $path = $sqlWalker->walkStringPrimary($this->path);

            return sprintf('JSON_CONTAINS(%s, %s, %s)', $target, $candidate, $path);
        }

        return sprintf('JSON_CONTAINS(%s, %s)', $target, $candidate);
    }
}
