<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\WhereClause;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * CountFilterFunction ::= "COUNT_FILTER" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://www.postgresql.org/docs/current/sql-expressions.html#SYNTAX-AGGREGATES
 *
 * @example SELECT COUNT_FILTER(*, WHERE foo.bar < 3) FROM entity
 *
 * @todo rename class to CountFilter
 */
class CountFilterFunction extends FunctionNode
{
    /** @var Node|string */
    public $countExpression = null;

    /** @var WhereClause */
    public $whereExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->countExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->whereExpression = $parser->WhereClause();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'COUNT(%s) FILTER(%s)',
            $this->countExpression->dispatch($sqlWalker),
            $this->whereExpression->dispatch($sqlWalker)
        );
    }
}
