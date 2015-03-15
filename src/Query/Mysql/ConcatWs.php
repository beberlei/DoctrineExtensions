<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Andrew Mackrodt <andrew@ajmm.org>
 */
class ConcatWs extends FunctionNode
{
    private $values = array();
    private $notEmpty = false;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        // Add the concat separator to the values array.
        $this->values[] = $parser->ArithmeticExpression();

        // Add the rest of the strings to the values array. CONCAT_WS must
        // be used with at least 2 strings not including the separator.

        $lexer = $parser->getLexer();

        while (count($this->values) < 3 || $lexer->lookahead['type'] == Lexer::T_COMMA) {
            $parser->match(Lexer::T_COMMA);
            $peek = $lexer->glimpse();

            $this->values[] = $peek['value'] == '('
                    ? $parser->FunctionDeclaration()
                    : $parser->ArithmeticExpression();
        }

        while ($lexer->lookahead['type'] == Lexer::T_IDENTIFIER) {
            switch (strtolower($lexer->lookahead['value'])) {
                case 'notempty':
                    $parser->match(Lexer::T_IDENTIFIER);
                    $this->notEmpty = true;
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
        // Create an array to hold the query elements.
        $queryBuilder = array('CONCAT_WS(');

        // Iterate over the captured expressions and add them to the query.
        for ($i = 0; $i < count($this->values); $i++) {
            if ($i > 0) {
                $queryBuilder[] = ', ';
            }

            // Dispatch the walker on the current node.
            $nodeSql = $sqlWalker->walkArithmeticPrimary($this->values[$i]);

            if ($this->notEmpty) {
                // Exclude empty strings from the concatenation.
                $nodeSql = sprintf("NULLIF(%s, '')", $nodeSql);
            }

            $queryBuilder[] = $nodeSql;
        }

        // Close the query.
        $queryBuilder[] = ')';

        // Return the joined query.
        return implode('', $queryBuilder);
    }
}
