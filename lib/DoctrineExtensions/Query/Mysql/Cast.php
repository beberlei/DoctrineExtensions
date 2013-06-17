<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * CastFunction ::=
 *     "CAST" "(" ArithmeticPrimary " AS " Identifier Identifier ")"
 */
class Cast extends FunctionNode
{
    public $arithmeticExpression = null;
    public $match = null;
    public $match2 = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_AS);
        $parser->match(Lexer::T_IDENTIFIER);

        /* @var $lexer Lexer */
        $lexer = $parser->getLexer();
        $this->match = $lexer->token['value'];

        $parser->match(Lexer::T_IDENTIFIER);

        /* @var $lexer Lexer */
        $lexer = $parser->getLexer();
        $this->match2 = $lexer->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'CAST(' .
            $this->arithmeticExpression->dispatch($sqlWalker) . ' AS ' . $this->match . ' ' . $this->match2 .
        ')';
    }
}
