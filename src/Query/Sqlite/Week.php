<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\TokenType;

/** @author Aleksandr Klimenkov <alx.devel@gmail.com> */
class Week extends NumberFromStrfTime
{
    /**
     * Currently not in use
     *
     * @var Literal
     */
    public $mode;

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

    protected function getFormat(): string
    {
        return '%W';
    }
}
