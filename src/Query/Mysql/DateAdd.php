<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function in_array;
use function is_string;
use function strtoupper;

class DateAdd extends FunctionNode
{
    public $firstDateExpression = null;

    public $intervalExpression = null;

    public $unit = null;

    protected static $allowedUnits = [
        'MICROSECOND',
        'SECOND',
        'MINUTE',
        'HOUR',
        'DAY',
        'WEEK',
        'MONTH',
        'QUARTER',
        'YEAR',
        'SECOND_MICROSECOND',
        'MINUTE_MICROSECOND',
        'MINUTE_SECOND',
        'HOUR_MICROSECOND',
        'HOUR_SECOND',
        'HOUR_MINUTE',
        'DAY_MICROSECOND',
        'DAY_SECOND',
        'DAY_MINUTE',
        'DAY_HOUR',
        'YEAR_MONTH',
    ];

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->firstDateExpression = $parser->ArithmeticFactor();

        $parser->match(TokenType::T_COMMA);
        $this->intervalExpression = $parser->ArithmeticFactor();

        $parser->match(TokenType::T_COMMA);
        $this->unit = $parser->StringPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $unit = strtoupper(is_string($this->unit) ? $this->unit : $this->unit->value);

        if (! in_array($unit, self::$allowedUnits)) {
            throw QueryException::semanticalError('DATE_ADD() does not support unit "' . $unit . '".');
        }

        return 'DATE_ADD(' .
            $sqlWalker->walkArithmeticTerm($this->firstDateExpression) . ', INTERVAL ' .
            $sqlWalker->walkArithmeticTerm($this->intervalExpression) . ' ' . $unit .
        ')';
    }
}
