<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class JsonExtract extends FunctionNode
{
    protected $target;

    protected $paths = [];

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->target = $parser->StringExpression();

        $parser->match(Lexer::T_COMMA);

        $this->paths[] = $parser->StringPrimary();

        while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);

            $this->paths[] = $parser->StringPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $target = $sqlWalker->walkStringPrimary($this->target);
        $paths = array_map([$sqlWalker, 'walkStringPrimary'], $this->paths);

        return sprintf('JSON_EXTRACT(%s, %s)', $target, implode(', ', $paths));
    }
}
