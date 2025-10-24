<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_left
 *
 * @author Cyril 'Yepzy' B <me@yepzy.dev>
 */
class Left extends FunctionNode
{
    private $field;
    private $length;

    /**
     * @throws QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->StringPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->length = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'LEFT(' .
            $this->field->dispatch($sqlWalker) . ', ' .
            $this->length->dispatch($sqlWalker) .
        ')';
    }
}
