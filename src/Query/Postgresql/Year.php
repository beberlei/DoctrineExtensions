<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * YearFunction ::= "YEAR" "(" ArithmeticPrimary ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-datetime.html#FUNCTIONS-DATETIME-EXTRACT
 *
 * @example SELECT YEAR(foo.bar) FROM entity
 */
class Year extends FunctionNode
{
    /** @var Node|string */
    private $date;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'EXTRACT(YEAR FROM %s)',
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
