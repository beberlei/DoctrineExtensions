<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Usage:   "CONVERT_TZ" "(" ArithmeticPrimary "," StringPrimary "," StringPrimary ")"
 * Example: "SELECT CONVERT_TZ(now(),'US/Eastern','US/Central');"
 *
 * CONVERT_TZ() is convert from one timezone to another.
 *
 * @category DoctrineExtensions
 * @package  DoctrineExtensions\Query\Mysql
 * @author   Alişan ALAÇAM  <alisanalacam@gmail.com>
 * @license  BSD License
 *
 */
class ConvertTz extends FunctionNode
{
    public $dateExpression;
    public $fromTz;
    public $toTz;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->dateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);

        $this->fromTz = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);

        $this->toTz = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $parts = [
            $sqlWalker->walkArithmeticPrimary($this->dateExpression),
            $sqlWalker->walkStringPrimary($this->fromTz),
            $sqlWalker->walkStringPrimary($this->toTz)
        ];

        return sprintf('CONVERT_TZ(%s)', implode(', ', $parts));
    }
}