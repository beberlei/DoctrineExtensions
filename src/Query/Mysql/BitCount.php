<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * BitCountFunction ::= "BIT_COUNT" "(" SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/bit-functions.html#function_bit-count
 *
 * @example SELECT BIT_COUNT(foo.bar) FROM entity
 * @example SELECT BIT_COUNT(2)
 */
class BitCount extends FunctionNode
{
    /** @var Node|string */
    public $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'BIT_COUNT(' . $sqlWalker->walkSimpleArithmeticExpression(
            $this->arithmeticExpression
        )
        . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
