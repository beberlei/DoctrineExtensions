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
 * Mysql Replace function
 *
 * Usage:
 *
 * REPLACE(str,from_str,to_str)
 * REPLACE('www.mysql.com', 'w', 'Ww')
 *
 * @author  Jarek Kostrz <jkostrz@gmail.com>
 */
class Replace extends FunctionNode
{
    public $search = null;
    public $replace = null;
    public $subject = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->subject = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->search = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->replace = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'replace(' .
            $this->subject->dispatch($sqlWalker) . ', ' .
            $this->search->dispatch($sqlWalker) . ', ' .
            $this->replace->dispatch($sqlWalker) .
        ')';
    }
}
