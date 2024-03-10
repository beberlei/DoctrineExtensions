<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @example SELECT REGEXP_SUBSTR('abc def ghi', '[a-z]+');
 * @link https://dev.mysql.com/doc/refman/8.0/en/regexp.html#function_regexp-substr
 */
class RegexpSubStr extends FunctionNode
{
    public $field = null;

    public $regex = null;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'REGEXP_SUBSTR(' .
            $this->field->dispatch($sqlWalker) . ', ' .
            $this->regex->dispatch($sqlWalker) .
        ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->field = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->regex = $parser->StringExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
