<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * StringAggFunction ::= "STRING_AGG" "(" ["DISTINCT"] PathExpression "," StringPrimary [ OrderByClause ] ")"
 *
 * @link https://www.postgresql.org/docs/9.0/sql-expressions.html#SYNTAX-AGGREGATES
 *
 * @author Roberto Júnior <me@robertojunior.net>
 * @author Vaskevich Eugeniy <wbrframe@gmail.com>
 *
 * @example SELECT STRING_AGG(DISTINCT foo.bar, "," ORDER BY foo.bar) FROM entity
 */
class StringAgg extends FunctionNode
{
    /** @var OrderByClause */
    private $orderBy = null;

    /** @var PathExpression  */
    private $expression = null;

    /** @var Node */
    private $delimiter = null;

    /** @var bool  */
    private $isDistinct = false;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(TokenType::T_DISTINCT)) {
            $parser->match(TokenType::T_DISTINCT);

            $this->isDistinct = true;
        }

        $this->expression = $parser->PathExpression(PathExpression::TYPE_STATE_FIELD);
        $parser->match(TokenType::T_COMMA);
        $this->delimiter = $parser->StringPrimary();

        if ($lexer->isNextToken(TokenType::T_ORDER)) {
            $this->orderBy = $parser->OrderByClause();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'string_agg(%s%s, %s%s)',
            ($this->isDistinct ? 'DISTINCT ' : ''),
            $sqlWalker->walkPathExpression($this->expression),
            $sqlWalker->walkStringPrimary($this->delimiter),
            ($this->orderBy ? $sqlWalker->walkOrderByClause($this->orderBy) : '')
        );
    }
}
