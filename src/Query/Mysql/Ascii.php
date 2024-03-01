<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * AsciiFunction ::= "ASCII" "(" ArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_ascii
 *
 * @example SELECT ASCII(foo.bar) FROM entity
 * @example SELECT ASCII('2')
 * @example SELECT ASCII(2)
 */
class Ascii extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $string;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'ASCII(' . $sqlWalker->walkArithmeticPrimary($this->string) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->string = $parser->ArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
