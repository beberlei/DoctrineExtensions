<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * AddTimeFunction ::= "ADDTIME" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_addtime
 *
 * @author Pascal Wacker <hello@pascalwacker.ch>
 * @example SELECT ADDTIME('2019-03-01 14:35:00', '01:02:03')
 * @example SELECT ADDTIME(foo.bar, '01:02:03') FROM entity
 */
class AddTime extends FunctionNode
{
    /** @var Node|string */
    public $date;

    /** @var Node|string */
    public $time;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'ADDTIME(' . $sqlWalker->walkArithmeticPrimary($this->date) . ', ' . $sqlWalker->walkArithmeticPrimary($this->time) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->time = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
