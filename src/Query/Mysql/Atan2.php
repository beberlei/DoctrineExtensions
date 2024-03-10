<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * Atan2Function ::= "ATAN2" "(" SimpleArithmeticExpression "," SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/mathematical-functions.html#function_atan2
 *
 * @example SELECT ATAN2(-2, 2)
 * @example SELECT ATAN2(PI(), 2)
 * @example SELECT ATAN2(foo.bar, 2) FROM entity
 */
class Atan2 extends FunctionNode
{
    /** @var Node|string */
    public $firstExpression;

    /** @var Node|string */
    public $secondExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        $firstArgument = $sqlWalker->walkSimpleArithmeticExpression(
            $this->firstExpression
        );

        $secondArgument = $sqlWalker->walkSimpleArithmeticExpression(
            $this->secondExpression
        );

        return 'ATAN2(' . $firstArgument . ', ' . $secondArgument . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->firstExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_COMMA);

        $this->secondExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
