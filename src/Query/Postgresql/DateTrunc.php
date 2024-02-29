<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

class DateTrunc extends FunctionNode
{
    public $fieldText = null;

    public $fieldTimestamp = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->fieldText = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->fieldTimestamp = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'DATE_TRUNC(%s, %s)',
            $this->fieldText->dispatch($sqlWalker),
            $this->fieldTimestamp->dispatch($sqlWalker)
        );
    }
}
