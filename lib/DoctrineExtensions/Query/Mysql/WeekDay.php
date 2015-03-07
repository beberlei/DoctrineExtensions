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

namespace DoctrineMgidExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\Parser,
    Doctrine\ORM\Query\SqlWalker;

/**
 * "WEEKDAY" "(" SimpleArithmeticExpression ")".<br>
 * Modified from DoctrineExtensions\Query\Mysql\Week<br>
 * Returns the weekday index for "date" (0 = Monday, 1 = Tuesday, … 6 = Sunday).<br>
 *
 * <code>
 * mysql> SELECT WEEKDAY('2008-02-03 22:23:00');
 * -> 6
 * mysql> SELECT WEEKDAY('2007-11-06');
 * -> 1
 * </code>
 *
 * @see http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_weekday
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Query\Mysql
 * @author      Pavlo Cherniavskyi <ionafan2@gmail.com>
 *
 * @license     MIT License
 */
class WeekDay extends FunctionNode
{
    private $date;

    /**
     * @override
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return "WEEKDAY(" . $sqlWalker->walkArithmeticPrimary($this->date) . ")";
    }

    /**
     * @override
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
