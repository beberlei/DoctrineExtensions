<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/** @author Steve Tauber <taubers@gmail.com> */
class Soundex extends FunctionNode
{
    public $stringPrimary;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'SOUNDEX(' . $sqlWalker->walkStringPrimary($this->stringPrimary) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
