<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * FindInSetFunction ::= "FIND_IN_SET" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_find-in-set
 *
 * @example SELECT FIND_IN_SET(foo.bar, foo.bar2) FROM entity
 * @example SELECT FIND_IN_SET('str', 'a,b,str') FROM entity
 */
class FindInSet extends FunctionNode
{
    /** @var Node|string */
    public $needle = null;

    /** @var Node|string */
    public $haystack = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->needle = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->haystack = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'FIND_IN_SET(' .
            $this->needle->dispatch($sqlWalker) . ', ' .
            $this->haystack->dispatch($sqlWalker) .
        ')';
    }
}
