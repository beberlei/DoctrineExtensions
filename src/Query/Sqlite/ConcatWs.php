<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Bas de Ruiter <winkbrace@gmail.com>
 */
class ConcatWs extends FunctionNode
{
    private $values = [];

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
        $separator = $this->values[0]->simpleArithmeticExpression->value;

        // Create an array to hold the query elements.
        $queryBuilder = ['('];

        // Iterate over the captured expressions and add them to the query.
        for ($i = 1; $i < count($this->values); $i++) {
            if ($i > 1) {
                $queryBuilder[] = " || '${separator}' || ";
            }

            // Dispatch the walker on the current node.
            $queryBuilder[] = sprintf("IFNULL(%s, '')", $sqlWalker->walkArithmeticPrimary($this->values[$i]));
        }

        // Close the query.
        $queryBuilder[] = ')';

        // Return the joined query.
        return implode('', $queryBuilder);
    }
}
