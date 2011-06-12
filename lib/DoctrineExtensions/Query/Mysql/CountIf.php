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
 * Usage: COUNTIF(expr1, expr2 [ INVERSE ])
 * 
 * COUNTIF() returns the COUNT of rows where expr1 = expr2 by internally
 * constructing a case statment so that the expression
 * COUNT(CASE expr1 WHEN expr2 THEN 1 ELSE NULL END) is evaluated.
 * 
 * The function is able to return the COUNT of rows where expr1 <> expr2 by
 * passing the parameter INVERSE, i.e. COUNTIF(expr1, expr2 INVERSE).
 * 
 * @author  Andrew Mackrodt <andrew@ajmm.org>
 * @version 2011.06.12
 */
class CountIf extends FunctionNode
{
    private $expr1;
    private $expr2;
    private $inverse = false;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        
        $lexer = $parser->getLexer();
        
        while ($lexer->lookahead['type'] == Lexer::T_IDENTIFIER)
        {
            switch (strtolower($lexer->lookahead['value']))
            {
                case 'inverse':
                    $parser->match(Lexer::T_IDENTIFIER);
                    $this->inverse = true;
                break;
                
                default: // Identifier not recognized (causes exception).
                    $parser->match(Lexer::T_CLOSE_PARENTHESIS);
                break;
            }
        }
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
        		"COUNT(CASE %s WHEN %s THEN %s END)",
                $sqlWalker->walkArithmeticPrimary($this->expr1),
                $sqlWalker->walkArithmeticPrimary($this->expr2),
                !$this->inverse ? '1 ELSE NULL' : 'NULL ELSE 1');
    }
}
