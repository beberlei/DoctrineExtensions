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

    public $fieldTimezone = null;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->fieldText = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->fieldTimestamp = $parser->ArithmeticPrimary();
        if ($parser->getLexer()->lookahead['type'] === Lexer::T_COMMA) {
            $parser->match(Lexer::T_COMMA);
            $this->fieldTimezone = $parser->ArithmeticPrimary();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $sql = sprintf(
            'DATE_TRUNC(%s, %s',
            $this->fieldText->dispatch($sqlWalker),
            $this->fieldTimestamp->dispatch($sqlWalker)
        );

        if ($this->fieldTimezone !== null) {
            $sql .= sprintf(', %s', $this->fieldTimezone->dispatch($sqlWalker));
        }

        $sql .= ')';

        return $sql;
    }
}
