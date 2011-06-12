<?php

/**
 * DoctrineExtensions Mysql Function Pack
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * Usage: NULLIF(expr1, expr2)
 * 
 * Returns NULL if expr1 = expr2 is true, otherwise returns expr1. This is the
 * same as CASE WHEN expr1 = expr2 THEN NULL ELSE expr1 END. 
 * 
 * @author  Andrew Mackrodt <andrew@ajmm.org>
 * @version 2011.06.12
 */
class NullIf extends FunctionNode
{
    private $expr1;
    private $expr2;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
                'NULLIF(%s, %s)',
                $sqlWalker->walkArithmeticPrimary($this->expr1),
                $sqlWalker->walkArithmeticPrimary($this->expr2));
    }
}