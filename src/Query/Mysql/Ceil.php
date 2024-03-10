<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * CeilFunction ::= "CEIL" "(" SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/mathematical-functions.html#function_ceil
 *
 * @example SELECT CEIL(foo.bar) FROM entity
 * @example SELECT CEIL(2)
 */
class Ceil extends FunctionNode
{
    /** @var Node|string */
    private $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'CEIL(' . $sqlWalker->walkSimpleArithmeticExpression($this->arithmeticExpression) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
