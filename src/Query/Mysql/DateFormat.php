<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * DateFormatFunction ::= "DATEFORMAT" "(" ArithmeticExpression "," StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_date-format
 *
 * @author Steve Lacey <steve@steve.ly>
 *
 * @example SELECT DATEFORMAT('2024-05-06', '%a')
 * @example SELECT DATEFORMAT(foo.bar, '%H') FROM entity
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
        return 'DATE_FORMAT(' .
            $this->dateExpression->dispatch($sqlWalker) . ', ' .
            $this->patternExpression->dispatch($sqlWalker) .
        ')';
    }
}
