<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * RegexpFunction ::= "(" StringPrimary "REGEXP" StringExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/regexp.html#operator_regexp
 *
 * @example
 */
class Regexp extends FunctionNode
{
    public $value = null;

    public $regexp = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->value = $parser->StringPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->regexp = $parser->StringExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return '(' . $this->value->dispatch($sqlWalker) . ' REGEXP ' . $this->regexp->dispatch($sqlWalker) . ')';
    }
}
