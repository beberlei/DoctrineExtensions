<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * ConvertTzFunction ::= "CONVERT_TZ" "(" ArithmeticExpression "," StringPrimary "," StringPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_convert-tz
 *
 * @example SELECT CONVERT_TZ(foo.bar, 'GMT', 'CEST') FROM entity
 * @example SELECT CONVERT_TZ('2024-02-06 12:00:00', 'GMT', 'CEST')
 */
class ConvertTz extends FunctionNode
{
    /** @var ArithmeticExpression */
    protected $dateExpression;

    /** @var Node */
    protected $fromTz;

    /** @var Node */
    protected $toTz;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'CONVERT_TZ(%s, %s, %s)',
            $sqlWalker->walkArithmeticExpression($this->dateExpression),
            $sqlWalker->walkStringPrimary($this->fromTz),
            $sqlWalker->walkStringPrimary($this->toTz)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);

        $this->fromTz = $parser->StringPrimary();
        $parser->match(TokenType::T_COMMA);

        $this->toTz = $parser->StringPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
