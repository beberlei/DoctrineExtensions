<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_time-to-sec
 *
 * @example SELECT TIME_TO_SEC('22:23:00');
 * @author Pawel Stasicki <p.stasicki@gmail.com>
 */
class TimeToSec extends FunctionNode
{
    public $time;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'TIME_TO_SEC(' . $sqlWalker->walkArithmeticPrimary($this->time) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
