<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * This class fakes a DATE_FORMAT method for SQLite, so that we can use sqlite as drop-in replacement
 * database in our tests.
 *
 * @author Bas de Ruiter
 */
class DateFormat extends FunctionNode
{
    private $date;
    private $format;

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'STRFTIME('
            . $sqlWalker->walkArithmeticPrimary($this->format)
            . ', '
            . $sqlWalker->walkArithmeticPrimary($this->date)
            . ')';
    }

    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     * @return void
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->format = $this->convertFormat($parser->ArithmeticExpression());
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Convert the MySql DATE_FORMAT() substitutions to Sqlite STRFTIME() substitutions
     * @param ArithmeticExpression $expr
     * @return ArithmeticExpression
     */
    private function convertFormat(ArithmeticExpression $expr)
    {
        // The order of the array is important. %i converts to %M, but %M converts to %m, so %M has to be done first.
        $conversion = array(
            '%a' => '%w',       // Abbreviated weekday name (Sun..Sat)          -> day of week (0..6)
            '%b' => '%m',       // Abbreviated month name (Jan..Dec)            -> month (01..12)
            '%c' => '%m',       // Month, numeric (0..12)                       -> month (01..12)
            '%D' => '%d',       // Day of the month with English suffix (0th, 1st, 2nd, …) -> day of month (01..31)
            '%d' => '%d',       // Day of the month, numeric (00..31)           -> day of month (01..31)
            '%e' => '%d',       // Day of the month, numeric (0..31)            -> day of month (01..31)
            '%f' => '%f',       // Microseconds (000000..999999)                -> fractional seconds: SS.SSS
            '%H' => '%H',       // Hour (00..23)                                -> Hour (00..23)
            '%h' => '%H',       // Hour (01..12)                                -> Hour (00..23)
            '%I' => '%H',       // Hour (01..12)                                -> Hour (00..23)
            '%j' => '%j',       // Day of year (001..366)                       -> Day of year (001..366)
            '%k' => '%H',       // Hour (0..23)                                 -> Hour (0..23)
            '%l' => '%H',       // Hour (1..12)                                 -> Hour (0..23)
            '%M' => '%m',       // Month name (January..December)               -> month (01..12)
            '%m' => '%m',       // Month, numeric (00..12)                      -> month (01..12)
            '%i' => '%M',       // Minutes, numeric (00..59)                    -> minutes (00..59)
            '%p' => '',         // AM or PM                                     -> '' (ignored)
            '%S' => '%S',       // Seconds (00..59)                             -> Seconds (00..59)
            '%s' => '%S',       // Seconds (00..59)                             -> Seconds (00..59)
            '%W' => '%w',       // Weekday name (Sunday..Saturday)              -> day of week (0..6)
            '%U' => '%W',       // Week (00..53), starting Sunday               -> week of year: (00..53)
            '%u' => '%W',       // Week (00..53), starting Monday               -> week of year: (00..53)
            '%V' => '%W',       // ISO Week (00..53), starting Sunday           -> week of year: (00..53)
            '%v' => '%W',       // ISO Week (00..53), starting Monday           -> week of year: (00..53)
            '%w' => '%w',       // Day of the week (0=Sunday..6=Saturday)       -> day of week (0..6)
            '%X' => '%Y',       // ISO Week Year (YYYY), week starting Sunday   -> year (four digits)
            '%x' => '%Y',       // ISO Week Year (YYYY), week starting Monday   -> year (four digits)
            '%Y' => '%Y',       // Year, numeric (four digits)                  -> year (four digits)
            '%y' => '%Y',       // Year, numeric (two digits)                   -> year (four digits)

            // these two last, so they will not get overwritten
            '%r' => '%H:%M:%S', // Time, 12-hour (hh:mm:ss followed by AM or PM) -> Time, 24-hour (hh:mm:ss)
            '%T' => '%H:%M:%S', // Time, 24-hour (hh:mm:ss)                      -> Time, 24-hour (hh:mm:ss)
        );

        $format = $expr->simpleArithmeticExpression->value;

        foreach ($conversion as $mysqlSub => $sqliteSub) {
            $format = str_replace($mysqlSub, $sqliteSub, $format);
        }

        $expr->simpleArithmeticExpression->value = $format;

        return $expr;
    }
}
