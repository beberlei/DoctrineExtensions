<?php

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Pascal Wacker <hello@pascalwacker.ch>
 */
class AddTime extends FunctionNode
{
    public $date;

    public $time;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATEADD(TIME, ' . $sqlWalker->walkArithmeticPrimary($this->date) . ', CAST(' . $sqlWalker->walkArithmeticPrimary($this->time) . ' AS TIME))';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
