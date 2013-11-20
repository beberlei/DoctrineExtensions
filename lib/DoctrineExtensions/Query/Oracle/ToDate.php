<?php

/*
 * DoctrineExtensions Oracle Function Pack
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Usage: TO_DATE(string,fmt)
 *
 * Returns a date converted from char of CHAR, VARCHAR2, NCHAR, or NVARCHAR2 datatype. 
 * The fmt is a datetime model format specifying the format of char
 *
 * @author  Mohammad ZeinEddin <mohammad@zeineddin.name>
 */
class ToDate extends FunctionNode
{
    private $date;
    private $fmt;
    
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
                'TO_DATE(%s, %s)',
                $sqlWalker->walkArithmeticPrimary($this->date),
                $sqlWalker->walkArithmeticPrimary($this->fmt));
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->fmt = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
