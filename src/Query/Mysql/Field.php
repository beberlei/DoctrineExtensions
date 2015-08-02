<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * @author Jeremy Hicks <jeremy.hicks@gmail.com>
 */
class Field extends FunctionNode
{
    private $field = null;
    private $values = array();

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        // Do the field.
        $this->field = $parser->ArithmeticPrimary();

        // Add the strings to the values array. FIELD must
        // be used with at least 1 string not including the field.

        $lexer = $parser->getLexer();

        while (count($this->values) < 1 ||
            $lexer->lookahead['type'] != Lexer::T_CLOSE_PARENTHESIS) {
            $parser->match(Lexer::T_COMMA);
            $this->values[] = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $query = 'FIELD(';

        $query .= $this->field->dispatch($sqlWalker);

        $query .= ', ';

        for ($i = 0; $i < count($this->values); $i++) {
            if ($i > 0) {
                $query .= ', ';
            }

            $query .= $this->values[$i]->dispatch($sqlWalker);
        }

        $query .= ')';

        return $query;
    }
}
