<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * "BIT_XOR" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class BitXor extends FunctionNode
{
    public $firstArithmetic;

    public $secondArithmetic;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->firstArithmetic->dispatch($sqlWalker)
            . ' ^ '
            . $this->secondArithmetic->dispatch($sqlWalker);
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->firstArithmetic = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->secondArithmetic = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
