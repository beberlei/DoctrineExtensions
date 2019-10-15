<?php

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Teresa Waldl <teresa@waldl.org>
 */
class YearWeek extends FunctionNode
{
    public $date;

    public $mode;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = 'YEAR(' . $sqlWalker->walkArithmeticPrimary($this->date) . ') * 100 + ' . 'DATEPART(WEEK, ' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
        if ($this->mode != null) {
            $sql .= ', ' . $sqlWalker->walkLiteral($this->mode);
        }
        $sql .= ')';

        return $sql;
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        if (Lexer::T_COMMA === $parser->getLexer()->lookahead['type']) {
            $parser->match(Lexer::T_COMMA);
            $this->mode = $parser->Literal();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
