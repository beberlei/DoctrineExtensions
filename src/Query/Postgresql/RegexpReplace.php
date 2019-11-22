<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * RegexpReplace string using postgresql function regexp_replace :
 * https://www.postgresql.org/docs/9.6/functions-matching.html#FUNCTIONS-POSIX-TABLE
 *
 * Usage : StringFunction REGEXP_REPLACE(string, search, replace)
 */
class RegexpReplace extends FunctionNode
{
    private $string;

    private $search;

    private $replace;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'REGEXP_REPLACE('.$this->string->dispatch($sqlWalker).', '.$this->search->dispatch($sqlWalker).', '.$this->replace->dispatch($sqlWalker).')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->string = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->search = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);
        $this->replace = $parser->StringExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
