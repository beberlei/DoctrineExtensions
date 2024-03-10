<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * MinuteFunction ::= "MINUTE" "(" ArithmeticPrimary ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-datetime.html#FUNCTIONS-DATETIME-EXTRACT
 *
 * @example SELECT MINUTE(foo.bar) FROM entity
 */
class Minute extends FunctionNode
{
    /** @var Node|string */
    private $date;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'EXTRACT(MINUTE FROM %s)',
            $sqlWalker->walkArithmeticPrimary($this->date)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
