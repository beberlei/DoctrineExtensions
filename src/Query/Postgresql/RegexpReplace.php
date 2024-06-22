<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\Subselect;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * RegexpReplaceFunction ::= "REGEXP_REPLACE" "(" StringPrimary "," StringExpression "," StringExpression ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-matching.html#FUNCTIONS-POSIX-TABLE
 *
 * @example SELECT REGEXP_REPLACE(string, search, replace)
 */
class RegexpReplace extends FunctionNode
{
    /** @var Node */
    private $string;

    /** @var Subselect|Node|string */
    private $search;

    /** @var Subselect|Node|string */
    private $replace;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'REGEXP_REPLACE(' . $this->string->dispatch($sqlWalker) . ', ' . $this->search->dispatch($sqlWalker) . ', ' . $this->replace->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->string = $parser->StringPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->search = $parser->StringExpression();
        $parser->match(TokenType::T_COMMA);
        $this->replace = $parser->StringExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
