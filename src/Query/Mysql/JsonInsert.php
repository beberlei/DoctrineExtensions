<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class JsonInsert extends FunctionNode
{
    protected $target;

    protected $path;

    protected $value;

    protected $pathAndValue = [];

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->path = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->value = $parser->StringPrimary();

        while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);

            $this->pathAndValue [] = $parser->StringPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $target = $sqlWalker->walkStringPrimary($this->target);
        $path = $sqlWalker->walkStringPrimary($this->path);
        $value = $sqlWalker->walkStringPrimary($this->value);

        if (count($this->pathAndValue) > 0) {
            $pathAndValue = [];
            foreach ($this->pathAndValue as $elem) {
                $pathAndValue [] = $sqlWalker->walkStringPrimary($elem);
            }

            return sprintf('JSON_INSERT(%s, %s, %s, %s)', $target, $path, $value, implode(', ', $pathAndValue));
        }

        return sprintf('JSON_INSERT(%s, %s, %s)', $target, $path, $value);
    }
}
