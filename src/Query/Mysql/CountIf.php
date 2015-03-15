<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Andrew Mackrodt <andrew@ajmm.org>
 */
class CountIf extends FunctionNode
{
    private $expr1;
    private $expr2;
    private $inverse = false;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();

        $lexer = $parser->getLexer();

        while ($lexer->lookahead['type'] == Lexer::T_IDENTIFIER) {
            switch (strtolower($lexer->lookahead['value'])) {
                case 'inverse':
                    $parser->match(Lexer::T_IDENTIFIER);
                    $this->inverse = true;
                break;

                default: // Identifier not recognized (causes exception).
                    $parser->match(Lexer::T_CLOSE_PARENTHESIS);
                break;
            }
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            "COUNT(CASE %s WHEN %s THEN %s END)",
            $sqlWalker->walkArithmeticPrimary($this->expr1),
            $sqlWalker->walkArithmeticPrimary($this->expr2),
            !$this->inverse ? '1 ELSE NULL' : 'NULL ELSE 1'
        );
    }
}
