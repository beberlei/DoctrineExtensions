<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * "RADIANS" "(" SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/mathematical-functions.html#function_radians
 *
 * @example
 */
class Radians extends FunctionNode
{
    /** @var Node|string */
    public $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'RADIANS(' .
            $sqlWalker->walkSimpleArithmeticExpression(
                $this->arithmeticExpression
            ) .
        ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
