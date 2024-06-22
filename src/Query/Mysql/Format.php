<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * FormatFunction ::= "FORMAT" "(" SimpleArithmeticExpression "," SimpleArithmeticExpression ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_format
 *
 * @author Wally Noveno <wally.noveno@gmail.com>
 *
 * @example SELECT FORMAT(foo.bar, 2) FROM entity
 */
class Format extends FunctionNode
{
    /** @var Node|string */
    public $numberExpression = null;

    /** @var Node|string */
    public $patternExpression = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->numberExpression = $parser->SimpleArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->patternExpression = $parser->SimpleArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'FORMAT(' .
            $this->numberExpression->dispatch($sqlWalker) . ', ' .
            $this->patternExpression->dispatch($sqlWalker) .
        ')';
    }
}
