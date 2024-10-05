<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * LagFunction ::= "LAG" "(" StringExpression ["," ArithmeticPrimary ["," SimpleArithmeticExpression ]] ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/window-function-descriptions.html#function_lag
 *
 * @example {@see LagTest}
 */
class Lag extends FunctionNode
{
    /** @var AST\Subselect|AST\Node|string */
    private $aggregateExpression;

    /** @var AST\Node|string */
    private $offset;

    /** @var AST\Node|string */
    private $defaultValue;

    public function getSql(SqlWalker $sqlWalker): string
    {
        if (isset($this->offset, $this->defaultValue)) {
            return 'LAG(' . $sqlWalker->walkAggregateExpression($this->aggregateExpression) . ', ' . $sqlWalker->walkArithmeticPrimary($this->offset) . ', ' . $sqlWalker->walkSimpleArithmeticExpression($this->defaultValue) . ')';
        }

        if (isset($this->offset)) {
            return 'LAG(' . $sqlWalker->walkAggregateExpression($this->aggregateExpression) . ', ' . $sqlWalker->walkArithmeticPrimary($this->offset) . ')';
        }

        return 'LAG(' . $sqlWalker->walkAggregateExpression($this->aggregateExpression) . ')';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->aggregateExpression = $parser->StringExpression();
        if (! $lexer->isNextToken(TokenType::T_CLOSE_PARENTHESIS)) {
            $parser->match(TokenType::T_COMMA);
            $this->offset = $parser->ArithmeticPrimary();
        }

        if (! $lexer->isNextToken(TokenType::T_CLOSE_PARENTHESIS)) {
            $parser->match(TokenType::T_COMMA);
            $this->defaultValue = $parser->SimpleArithmeticExpression();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
