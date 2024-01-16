<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/** @author Michael Kimpton <mike@sketchthat.com> */
class YearWeek extends FunctionNode
{
    public $date;

    public $mode;

    public function getSql(SqlWalker $sqlWalker): string
    {
        $sql = 'YEARWEEK(' . $sqlWalker->walkArithmeticPrimary($this->date);
        if ($this->mode !== null) {
            $sql .= ', ' . $sqlWalker->walkLiteral($this->mode);
        }

        $sql .= ')';

        return $sql;
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        if ($parser->getLexer()->lookahead->type === TokenType::T_COMMA) {
            $parser->match(TokenType::T_COMMA);
            $this->mode = $parser->Literal();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
