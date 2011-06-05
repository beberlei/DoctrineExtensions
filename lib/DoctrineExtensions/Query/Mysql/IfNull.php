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
 * Usage: IFNULL(expr1, expr2)
 * 
 * If expr1 is not NULL, IFNULL() returns expr1; otherwise it returns expr2.
 * IFNULL() returns a numeric or string value, depending on the context in
 * which it is used.
 * 
 * @author  Andrew Mackrodt <andrew@ajmm.org>
 * @version 2011.06.05
 */
class IfNull extends FunctionNode
{
    private $columnToCheck;
    private $valueIfNull;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->columnToCheck = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->valueIfNull = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'IFNULL('
            .$sqlWalker->walkStringPrimary($this->columnToCheck). ', '
            .$sqlWalker->walkStringPrimary($this->valueIfNull).')';
    }
}