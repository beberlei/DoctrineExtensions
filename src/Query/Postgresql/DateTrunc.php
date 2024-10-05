<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * DateTruncFunction ::= "DATE_TRUNC" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://www.postgresql.org/docs/current/functions-datetime.html#FUNCTIONS-DATETIME-TRUNC
 *
 * @example SELECT DATE_TRUNC('hour', foo.bar) FROM entity
 */
class DateTrunc extends FunctionNode
{
    /** @var Node|string */
    public $fieldText = null;

    /** @var Node|string */
    public $fieldTimestamp = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->fieldText = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->fieldTimestamp = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'DATE_TRUNC(%s::text, %s::timestamp)',
            $this->fieldText->dispatch($sqlWalker),
            $this->fieldTimestamp->dispatch($sqlWalker)
        );
    }
}
