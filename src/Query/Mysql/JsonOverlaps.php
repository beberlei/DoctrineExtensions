<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class JsonOverlaps extends FunctionNode
{
    protected $doc1;

    protected $doc2;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->doc1 = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->doc2 = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $doc1 = $sqlWalker->walkStringPrimary($this->doc1);
        $doc2 = $sqlWalker->walkStringPrimary($this->doc2);
        return sprintf('JSON_OVERLAPS(%s, %s)', $doc1, $doc2);
    }
}
