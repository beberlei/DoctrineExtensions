<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class StrfTime extends FunctionNode
{
    public $date;

    public $formatter;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @throws \Doctrine\ORM\Query\QueryException
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'strftime('
        . $sqlWalker->walkLiteral($this->formatter)
        . ', '
        . $sqlWalker->walkArithmeticPrimary($this->date)
        . ')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->formatter = $parser->Literal();

        $parser->match(Lexer::T_COMMA);
        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
