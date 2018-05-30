<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * AtTimeZoneFunction ::= "AT_TIME_ZONE" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class AtTimeZoneFunction extends FunctionNode
{
    public $dateExpression = null;

    public $timezoneExpression = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->timezoneExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            '%s AT TIME ZONE %s',
            $this->dateExpression->dispatch($sqlWalker),
            $this->timezoneExpression->dispatch($sqlWalker)
        );
    }
}
