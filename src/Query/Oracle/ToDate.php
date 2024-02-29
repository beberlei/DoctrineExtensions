<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/** @author Mohammad ZeinEddin <mohammad@zeineddin.name> */
class ToDate extends FunctionNode
{
    private $date;

    private $fmt;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'TO_DATE(%s, %s)',
            $sqlWalker->walkArithmeticPrimary($this->date),
            $sqlWalker->walkArithmeticPrimary($this->fmt)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->fmt = $parser->StringExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
