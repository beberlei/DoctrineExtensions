<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Atan extends FunctionNode
{
    public $arithmeticExpression;

    public $optionalSecondExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        $secondArgument = '';

        if ($this->optionalSecondExpression) {
            $secondArgument = $sqlWalker->walkSimpleArithmeticExpression(
                $this->optionalSecondExpression
            );
        }

        return 'ATAN(' . $sqlWalker->walkSimpleArithmeticExpression(
            $this->arithmeticExpression
        ) . ($secondArgument ? ', ' . $secondArgument : '')
        . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        try {
            $parser->match(TokenType::T_COMMA);

            $this->optionalSecondExpression = $parser->SimpleArithmeticExpression();

            $parser->match(TokenType::T_CLOSE_PARENTHESIS);
        } catch (QueryException $e) {
            $parser->match(TokenType::T_CLOSE_PARENTHESIS);
        }
    }
}
