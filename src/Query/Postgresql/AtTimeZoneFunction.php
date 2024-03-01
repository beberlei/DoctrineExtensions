<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * AtTimeZoneFunction ::= "AT_TIME_ZONE" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-datetime.html#FUNCTIONS-DATETIME-ZONECONVERT
 *
 * @example SELECT AT_TIME_ZONE("2021-05-06", "CEST")
 * @example SELECT AT_TIME_ZONE(foo.bar, "CEST") FROM entity
 *
 * @todo rename class to AtTimeZone
 */
class AtTimeZoneFunction extends FunctionNode
{
    /** @var Node|string */
    public $dateExpression = null;

    /** @var Node|string */
    public $timezoneExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->dateExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->timezoneExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            '%s AT TIME ZONE %s',
            $this->dateExpression->dispatch($sqlWalker),
            $this->timezoneExpression->dispatch($sqlWalker)
        );
    }
}
