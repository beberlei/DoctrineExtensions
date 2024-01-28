<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/** @author Pascal Wacker <hello@pascalwacker.ch> */
class AddTime extends FunctionNode
{
    public $date;

    public $time;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'ADDTIME(' . $sqlWalker->walkArithmeticPrimary($this->date) . ', ' . $sqlWalker->walkArithmeticPrimary($this->time) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
