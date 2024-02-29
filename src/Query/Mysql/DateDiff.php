<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class DateDiff extends FunctionNode
{
    public $firstDateExpression = null;

    public $secondDateExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->secondDateExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'DATEDIFF(' .
            $sqlWalker->walkArithmeticTerm($this->firstDateExpression) . ', ' .
            $sqlWalker->walkArithmeticTerm($this->secondDateExpression) .
        ')';
    }
}
