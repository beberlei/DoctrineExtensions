<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * TimestampAddFunction ::= "TIMESTAMPADD" "(" Identifier "," ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_timestampadd
 *
 * @author Alessandro Tagliapietra <tagliapietra.alessandro@gmail.com>
 */
class TimestampAdd extends FunctionNode
{
    public $firstDatetimeExpression = null;

    public $secondDatetimeExpression = null;

    public $unit = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $parser->match(TokenType::T_IDENTIFIER);
        $lexer      = $parser->getLexer();
        $this->unit = $lexer->token->value;
        $parser->match(TokenType::T_COMMA);
        $this->firstDatetimeExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->secondDatetimeExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'TIMESTAMPADD(%s, %s, %s)',
            $this->unit,
            $this->firstDatetimeExpression->dispatch($sqlWalker),
            $this->secondDatetimeExpression->dispatch($sqlWalker)
        );
    }
}
