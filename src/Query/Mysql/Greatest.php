<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Class Greatest
 *
 * @author Vas N <phpvas@gmail.com>
 * @author Guven Atbakan <guven@atbakan.com>
 */
class Greatest extends FunctionNode
{
    private $field = null;

    private $values = [];

    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticExpression();
        $lexer = $parser->getLexer();

        while (count($this->values) < 1 ||
            $lexer->lookahead['type'] != Lexer::T_CLOSE_PARENTHESIS) {
            $parser->match(Lexer::T_COMMA);
            $this->values[] = $parser->ArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $query = 'GREATEST(';

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
