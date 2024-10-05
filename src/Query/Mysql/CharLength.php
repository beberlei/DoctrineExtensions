<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * CharLengthFunction ::= "CHAR_LENGTH" "(" ArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_char-length
 *
 * @author Metod <metod@simpel.si>
 * @example SELECT CHAR_LENGTH(foo.bar) FROM entity
 * @example SELECT CHAR_LENGTH("string")
 */
class CharLength extends FunctionNode
{
    /** @var ArithmeticExpression */
    private $expr1;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'CHAR_LENGTH(' . $sqlWalker->walkArithmeticPrimary($this->expr1) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->expr1 = $parser->ArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
