<?php

namespace DoctrineExtensions\Query\Mysql;

use Closure;
use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function array_map;
use function count;
use function implode;
use function strtolower;
use function trim;

class Over extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $windowFunction;

    /** @var ArithmeticExpression[] */
    private $partitionByClause;

    /** @var OrderByClause|null */
    private $orderByClause;

    public function getSql(SqlWalker $sqlWalker): string
    {
        $sql           = $sqlWalker->walkArithmeticExpression($this->windowFunction) . ' OVER (';
        $overClauseSQL = [];
        if ($this->partitionByClause !== null && count($this->partitionByClause) !== 0) {
            $partitionByClauseSQL = array_map(
                Closure::fromCallable([$sqlWalker, 'walkArithmeticExpression']),
                $this->partitionByClause
            );
            $overClauseSQL[]      = 'PARTITION BY ' . trim(implode(', ', $partitionByClauseSQL));
        }

        if ($this->orderByClause !== null && count($this->orderByClause->orderByItems) !== 0) {
            $overClauseSQL[] = trim($sqlWalker->walkOrderByClause($this->orderByClause));
        }

        return $sql . implode(' ', $overClauseSQL) . ')';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->windowFunction = $parser->ArithmeticExpression();
        if (
            ! $lexer->isNextToken(TokenType::T_CLOSE_PARENTHESIS)
            && $lexer->isNextToken(TokenType::T_COMMA)
        ) {
            $parser->match(TokenType::T_COMMA);
            if (
                $lexer->isNextToken(TokenType::T_IDENTIFIER)
                && strtolower($lexer->lookahead->value) === 'partition'
            ) {
                $parser->match(TokenType::T_IDENTIFIER);
                $parser->match(TokenType::T_BY);

                $this->partitionByClause[] = $parser->ArithmeticExpression();

                while ($lexer->isNextToken(TokenType::T_COMMA)) {
                    $parser->match(TokenType::T_COMMA);
                    $this->partitionByClause[] = $parser->ArithmeticExpression();
                }
            }

            if (
                $lexer->isNextToken(TokenType::T_ORDER)
                && strtolower($lexer->lookahead->value) === 'order'
            ) {
                $this->orderByClause = $parser->OrderByClause();
            }
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
