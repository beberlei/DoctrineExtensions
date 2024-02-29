<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/** @author Jefferson Vantuir <jefferson.behling@gmail.com> */
class Floor extends FunctionNode
{
    private $number;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'FLOOR(%s)',
            $sqlWalker->walkArithmeticPrimary($this->number)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->number = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
