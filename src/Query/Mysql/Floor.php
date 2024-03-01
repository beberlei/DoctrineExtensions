<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * FloorFunction ::= "FLOOR" "(" SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/mathematical-functions.html#function_floor
 *
 * @example SELECT FLOOR(3.14)
 * @example SELECT FLOOR(foo.bar) FROM entity
 */
class Floor extends FunctionNode
{
    /** @var Node|string */
    private $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'FLOOR(' . $sqlWalker->walkSimpleArithmeticExpression($this->arithmeticExpression) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
