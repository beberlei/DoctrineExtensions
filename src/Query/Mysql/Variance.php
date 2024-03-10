<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * VarianceFunction ::= "VARIANCE" "(" SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/aggregate-functions.html#function_variance
 *
 * @example
 */
class Variance extends FunctionNode
{
    /** @var Node|string */
    protected $arithmeticExpression;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf('VARIANCE(%s)', $sqlWalker->walkSimpleArithmeticExpression($this->arithmeticExpression));
    }
}
