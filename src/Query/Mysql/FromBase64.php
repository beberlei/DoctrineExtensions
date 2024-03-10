<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * FromBase64Function ::= "FROM_BASE64" "(" ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_from-base64
 *
 * @example SELECT FROM_BASE64(foo.bar) FROM entity
 */
class FromBase64 extends FunctionNode
{
    /** @var Node|string */
    public $field = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'FROM_BASE64(' . $this->field->dispatch($sqlWalker) . ')';
    }
}
