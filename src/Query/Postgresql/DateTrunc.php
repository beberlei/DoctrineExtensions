<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class DateTrunc extends FunctionNode
{
    public $fieldText = null;

    public $fieldTimestamp = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->fieldText = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->fieldTimestamp = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'DATE_TRUNC(%s, %s)',
            $this->fieldText->dispatch($sqlWalker),
            $this->fieldTimestamp->dispatch($sqlWalker)
        );
    }
}
