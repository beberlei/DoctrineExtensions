<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Converts timezones.
 *
 * Allows Doctrine 2 Query Language to execute a MySQL CONVERT_TZ function.
 *
 * @link http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_convert-tz
 */
class ConvertTz extends FunctionNode
{
    protected $dateExpression;
    protected $fromTz;
    protected $toTz;

    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'CONVERT_TZ(%s, %s, %s)',
            $sqlWalker->walkArithmeticExpression($this->dateExpression),
            $sqlWalker->walkStringPrimary($this->fromTz),
            $sqlWalker->walkStringPrimary($this->toTz)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->fromTz = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);

        $this->toTz = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
