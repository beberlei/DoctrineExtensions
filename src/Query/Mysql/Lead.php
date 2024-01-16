<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\AggregateExpression;
use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\SimpleArithmeticExpression;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Lead extends FunctionNode
{
    /** @var AggregateExpression */
    private $aggregateExpression;

    /** @var ArithmeticExpression */
    private $offset;

    /** @var SimpleArithmeticExpression */
    private $defaultValue;

    public function getSql(SqlWalker $sqlWalker): string
    {
        if (isset($this->offset, $this->defaultValue)) {
            return 'LEAD(' . $sqlWalker->walkAggregateExpression($this->aggregateExpression) . ', ' . $sqlWalker->walkArithmeticPrimary($this->offset) . ', ' . $sqlWalker->walkSimpleArithmeticExpression($this->defaultValue) . ')';
        }

        if (isset($this->offset)) {
            return 'LEAD(' . $sqlWalker->walkAggregateExpression($this->aggregateExpression) . ', ' . $sqlWalker->walkArithmeticPrimary($this->offset) . ')';
        }

        return 'LEAD(' . $sqlWalker->walkAggregateExpression($this->aggregateExpression) . ')';
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
