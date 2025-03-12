<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\Subselect;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @author Piotr Reclik <reclikp@gmail.com>
 * @example SELECT LIMIT((sub-query), limitValue)
 */
class Limit extends FunctionNode
{
    /** @var Subselect */
    private $subSelect;

    /** @var Literal */
    private $limit;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return "({$this->subSelect->dispatch($sqlWalker)} LIMIT {$this->limit->dispatch($sqlWalker)})";
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->subSelect = $parser->Subselect();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);

        $parser->match(TokenType::T_COMMA);

        $this->limit = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
