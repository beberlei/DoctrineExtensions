<?php

/*
 * DoctrineExtensions Mssql Function Pack
 *@author Teresa Waldl <teresa@waldl.org>
 */

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class YearMonth extends FunctionNode
{
    public $date;

    /**
     * @override
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = 'YEAR(' . $sqlWalker->walkArithmeticPrimary($this->date) . ') * 100 + MONTH(' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
        return $sql;
    }

    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
