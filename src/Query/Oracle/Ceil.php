<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

use function sprintf;

/** @author Jefferson Vantuir <jefferson.behling@gmail.com> */
class Ceil extends FunctionNode
{
    private $number;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'CEIL(%s)',
            $sqlWalker->walkArithmeticPrimary($this->number)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->number = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
