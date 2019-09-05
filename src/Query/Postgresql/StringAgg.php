<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Roberto Júnior <me@robertojunior.net>
 * @author Vaskevich Eugeniy <wbrframe@gmail.com>
 */
class StringAgg extends FunctionNode
{
    private $orderBy = null;

    private $expression = null;

    private $delimiter = null;

    private $isDistinct = false;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(Lexer::T_DISTINCT)) {
            $parser->match(Lexer::T_DISTINCT);

            $this->isDistinct = true;
        }

        $this->expression = $parser->PathExpression(PathExpression::TYPE_STATE_FIELD);
        $parser->match(Lexer::T_COMMA);
        $this->delimiter = $parser->StringPrimary();

        if ($lexer->isNextToken(Lexer::T_ORDER)) {
            $this->orderBy = $parser->OrderByClause();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return \sprintf(
            'string_agg(%s%s, %s%s)',
            ($this->isDistinct ? 'DISTINCT ' : ''),
            $sqlWalker->walkPathExpression($this->expression),
            $sqlWalker->walkStringPrimary($this->delimiter),
            ($this->orderBy ? $sqlWalker->walkOrderByClause($this->orderBy) : '')
        );
    }
}
