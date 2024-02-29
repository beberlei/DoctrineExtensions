<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/** @author winkbrace <winkbrace@gmail.com> */
class Replace extends FunctionNode
{
    public $search = null;

    public $replace = null;

    public $subject = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->subject = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->search = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->replace = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'REPLACE(' .
            $this->subject->dispatch($sqlWalker) . ', ' .
            $this->search->dispatch($sqlWalker) . ', ' .
            $this->replace->dispatch($sqlWalker) .
        ')';
    }
}
