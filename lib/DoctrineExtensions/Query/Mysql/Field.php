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
 * Usage: FIELD(str,str1,str2,str3,...)
 * 
 * FIELD returns the index (position) of str in the str1, str2, str3, ... list. 
 * Returns 0 if str is not found. If all arguments to FIELD() are strings, all 
 * arguments are compared as strings. If all arguments are numbers, they are 
 * compared as numbers. Otherwise, the arguments are compared as double.
 * If str is NULL, the return value is 0 because NULL fails equality comparison 
 * with any value. FIELD() is the complement of ELT(). (Taken from MySQL 
 * documentation.)
 * 
 * @author  Jeremy Hicks <jeremy.hicks@gmail.com>
 * @version 2011.06.09
 */

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class Field extends FunctionNode
{
    private $field = null;
    private $values = array();
    
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
		
        // Do the field.
        $this->field = $parser->ArithmeticPrimary();
		
        // Add the strings to the values array. FIELD must
        // be used with at least 1 string not including the field.
		
        $lexer = $parser->getLexer();
		
        while (count($this->values) < 1 || 
            $lexer->lookahead['type'] != Lexer::T_CLOSE_PARENTHESIS) {
            $parser->match(Lexer::T_COMMA);
            $this->values[] = $parser->ArithmeticPrimary();
        }
		
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
	
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $query = 'FIELD(';
		
        $query .= $this->field->dispatch($sqlWalker);
		
        $query .= ',';
		
        for ($i = 0; $i < count($this->values); $i++) {
            if ($i > 0) {
                $query .= ',';
            }
			
            $query .= $this->values[$i]->dispatch($sqlWalker);
        }
		
        $query .= ')';
		
        return $query;
    }
}