<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * DateFunction ::= "DATE" "(" ArithmeticPrimary ")"
 */
class Date extends FunctionNode
{
    /** @var Node|string */
    public $date;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'DATE(' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
