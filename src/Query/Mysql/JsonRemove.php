<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class JsonRemove extends FunctionNode
{
    protected $target;

    protected $path = [];

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->path [] = $parser->StringPrimary();

        while($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);

            $this->path [] = $parser->StringPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $target = $sqlWalker->walkStringPrimary($this->target);

        $pathWalker = [];
        foreach( $this->path as $path)
        {
            $pathWalker [] = $sqlWalker->walkStringPrimary($path);
        }

        return sprintf('JSON_REMOVE(%s, %s)', $target, implode(', ', $pathWalker));
    }
}
