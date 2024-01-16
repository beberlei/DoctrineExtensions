<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/** @author Tarjei Huse <tarjei.huse@gmail.com> */
class StrfTime extends FunctionNode
{
    public $date;

    public $formatter;

    /** @throws QueryException */
    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'strftime('
        . $sqlWalker->walkLiteral($this->formatter)
        . ', '
        . $sqlWalker->walkArithmeticPrimary($this->date)
        . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->formatter = $parser->Literal();

        $parser->match(TokenType::T_COMMA);
        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
