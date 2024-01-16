<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Atan2 extends FunctionNode
{
    public $firstExpression;

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
