<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/** @link https://dev.mysql.com/doc/refman/en/arithmetic-functions.html#operator_div */
class Div extends FunctionNode
{
    /** @var Node */
    private $dividend;

    /** @var Node */
    private $divisor;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $sqlWalker->walkArithmeticPrimary($this->dividend) . ' DIV ' .
            $sqlWalker->walkArithmeticPrimary($this->divisor);
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->dividend = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->divisor = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
