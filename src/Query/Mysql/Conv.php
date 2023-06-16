<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @example SELECT CONV(111,2,10);
 *
 * @link https://dev.mysql.com/doc/refman/8.0/en/mathematical-functions.html#function_conv
 *
 * @author technoknol github.com/technoknol
 */
class Conv extends FunctionNode
{
    public $string;

    public $fromBase;

    public $toBase;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'CONV(' . $this->string->dispatch($sqlWalker) . ', '
            . $this->fromBase->dispatch($sqlWalker) . ', '
            . $this->toBase->dispatch($sqlWalker) . ')';
    }

    /**
     * @throws QueryException
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->string = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->fromBase = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->toBase = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
