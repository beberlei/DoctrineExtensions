<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * DateFormatFunction ::= "DATE_FORMAT" "(" ArithmeticExpression "," StringPrimary ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-formatting.html#FUNCTIONS-FORMATTING-TABLE
 *
 * @author Silvio
 *
 * @example SELECT DATE_FORMAT(foo.bar, "HH23:MI:SS")
 */
class DateFormat extends FunctionNode
{
    /** @var ArithmeticExpression */
    public $dateExpression = null;

    /** @var Node */
    public $patternExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->patternExpression = $parser->StringPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'TO_CHAR(' .
            $this->dateExpression->dispatch($sqlWalker) . ', ' .
            $this->patternExpression->dispatch($sqlWalker) .
        ')';
    }
}
