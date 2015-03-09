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

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\QueryException;

class DateAdd extends FunctionNode
{

    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $unit = null;

    private static $allowedUnits = array(
        "MICROSECOND",
        "SECOND",
        "MINUTE",
        "HOUR",
        "DAY",
        "WEEK",
        "MONTH",
        "QUARTER",
        "YEAR",
        "SECOND_MICROSECOND",
        "MINUTE_MICROSECOND",
        "MINUTE_SECOND",
        "HOUR_MICROSECOND",
        "HOUR_SECOND",
        "HOUR_MINUTE",
        "DAY_MICROSECOND",
        "DAY_SECOND",
        "DAY_MINUTE",
        "DAY_HOUR",
        "YEAR_MONTH",
    );

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstDateExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->intervalExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->unit = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $unit = strtoupper($this->unit);
        if (!in_array($unit, self::$allowedUnits)) {
            throw QueryException::semanticalError('DATE_ADD() does not support unit "' . $unit . '".');
        }

        return 'DATE_ADD(' .
            $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
            $this->intervalExpression->dispatch($sqlWalker) . ' ' . $unit .
        ')';
    }

}
