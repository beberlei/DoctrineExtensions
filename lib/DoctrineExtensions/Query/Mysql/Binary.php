<?php
/**
 * DoctrineExtensions Mysql Function Binary
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
 * "BINARY" "(" stringPrimary ")"
 *
 * The BINARY operator casts the string following it to a binary string. 
 * This is an easy way to force a column comparison to be done byte by byte 
 * rather than character by character. This causes the comparison to be case 
 * sensitive even if the column is not defined as BINARY or BLOB. 
 * BINARY also causes trailing spaces to be significant.
 * 
 * @category DoctrineExtensions
 * @package  DoctrineExtensions\Query\Mysql
 * @author   Sarjono Mukti Aji <me@simukti.net>
 * @license  BSD License
 */
class Binary extends FunctionNode
{
    private $stringPrimary;
	
    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        
        $this->stringPrimary = $parser->StringPrimary();
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
	
    /**
     * @override
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'BINARY('.$sqlWalker->walkSimpleArithmeticExpression($this->stringPrimary).')';
    }
}