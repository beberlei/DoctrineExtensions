<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\AST\Subselect;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function implode;
use function sprintf;
use function strtolower;

/**
 * GroupConcatFunction ::= "GROUP_CONCAT" "(" ["DISTINCT"] StringExpression|SingleValuedPathExpression [{ "," StringPrimary }*] [ OrderByClause ] [ "SEPARATOR" StringPrimary ] ")"
 *
 * @link https://dev.mysql.com/doc/refman/8.0/en/aggregate-functions.html#function_group-concat
 *
 * @example GROUP_CONCAT(foo.bar, foo.bar2) FROM entity
 * @example GROUP_CONCAT(DISTINCT foo.bar, foo.bar2 ORDER BY foo.bar ASC, foo.bar2 DESC SEPARATOR ", ") FROM entity
 */
class GroupConcat extends FunctionNode
{
    /** @var bool */
    public $isDistinct = false;

    /** @var array<Subselect|Node|PathExpression|string> */
    public $pathExp = null;

    /** @var Node */
    public $separator = null;

    /** @var OrderByClause */
    public $orderBy = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(TokenType::T_DISTINCT)) {
            $parser->match(TokenType::T_DISTINCT);

            $this->isDistinct = true;
        }

        // first Path Expression is mandatory
        $this->pathExp = [];
        if ($lexer->isNextToken(TokenType::T_IDENTIFIER)) {
            $this->pathExp[] = $parser->StringExpression();
        } else {
            $this->pathExp[] = $parser->SingleValuedPathExpression();
        }

        while ($lexer->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);
            $this->pathExp[] = $parser->StringPrimary();
        }

        if ($lexer->isNextToken(TokenType::T_ORDER)) {
            $this->orderBy = $parser->OrderByClause();
        }

        if ($lexer->isNextToken(TokenType::T_IDENTIFIER)) {
            if (strtolower($lexer->lookahead->value) !== 'separator') {
                $parser->syntaxError('separator');
            }

            $parser->match(TokenType::T_IDENTIFIER);

            $this->separator = $parser->StringPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $result = 'GROUP_CONCAT(' . ($this->isDistinct ? 'DISTINCT ' : '');

        $fields = [];
        foreach ($this->pathExp as $pathExp) {
            $fields[] = $pathExp->dispatch($sqlWalker);
        }

        $result .= sprintf('%s', implode(', ', $fields));

        if ($this->orderBy) {
            $result .= ' ' . $sqlWalker->walkOrderByClause($this->orderBy);
        }

        if ($this->separator) {
            $result .= ' SEPARATOR ' . $sqlWalker->walkStringPrimary($this->separator);
        }

        $result .= ')';

        return $result;
    }
}
