<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @example SELECT REGEXP_REPLACE(string, search, replace)
 * @link https://www.postgresql.org/docs/current/functions-matching.html#FUNCTIONS-POSIX-TABLE
 */
class RegexpReplace extends FunctionNode
{
    private $string;

    private $search;

    private $replace;

    private $flags;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = 'REGEXP_REPLACE('.$this->string->dispatch($sqlWalker).', '.$this->search->dispatch($sqlWalker).', '.$this->replace->dispatch($sqlWalker);
        if ($this->flags) {
            $sql .= ', '.$this->flags->dispatch($sqlWalker);
        }
        $sql .= ')';

        return $sql;
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

        if ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->flags = $parser->StringExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
