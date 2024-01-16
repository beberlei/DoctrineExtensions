<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Power extends FunctionNode
{
    public $arithmeticExpression;

    public $power;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'POWER(' . $this->arithmeticExpression->dispatch($sqlWalker) . ', '
         . $this->power->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->power = $parser->ArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
