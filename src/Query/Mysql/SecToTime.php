<?php

/**
 * DoctrineExtensions Mysql Function Pack
 * LICENSE
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * "SEC_TO_TIME" "(" SimpleArithmeticExpression ")".
 * Modified from DoctrineExtensions\Query\Mysql\TimeToSec
 * More info:
 * https://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html
 *
 * @category    DoctrineExtensions
 * @author      Clemens Bastian <clemens.bastian@gmail.com>
 * @license     MIT License
 */
class SecToTime extends FunctionNode
{
    public $time;

    /**
     * @override
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'SEC_TO_TIME('.$sqlWalker->walkArithmeticPrimary($this->time).')';
    }

    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
