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
 * Usage: CONCAT_WS(SEPARATOR, STR1, STR2 ,...)
 * 
 * CONCAT_WS() stands for Concatenate With Separator and is a special form of
 * CONCAT(). The first argument is the separator for the rest of the arguments.
 * The separator is added between the strings to be concatenated. The separator
 * can be a string, as can the rest of the arguments. If the separator is NULL,
 * the result is NULL.
 * 
 * @author  Andrew Mackrodt <andrew@ajmm.org>
 * @version 2011.06.05
 */
class ConcatWs extends FunctionNode
{
    private $values = array();

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        
        // Add the concat separator to the values array.
        $this->values[] = $parser->StringPrimary();
        
        // Add the rest of the strings to the values array. CONCAT_WS must
        // be used with at least 2 strings not including the separator.
        
        $lexer = $parser->getLexer();
        
        while (count($this->values) < 3
                || $lexer->lookahead['type'] != Lexer::T_CLOSE_PARENTHESIS)
        {
            $parser->match(Lexer::T_COMMA);
            $this->values[] = $parser->StringPrimary();
        }
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        // Create an array to hold the query elements.
        $queryBuilder = array('CONCAT_WS(');
        
        // Iterate over the captured expressions and add them to the query.        
        for ($i = 0; $i < count($this->values); $i++)
        {
            if ($i > 0)
            {
                $queryBuilder[] = ', ';
            }
            
            $queryBuilder[] = $sqlWalker->walkStringPrimary($this->values[$i]);
        }
        
        // Close the query.
        $queryBuilder[] = ')';
        
        // Return the joined query.
        return implode('', $queryBuilder);
    }
}