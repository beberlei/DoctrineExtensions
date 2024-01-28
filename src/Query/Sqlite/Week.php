<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;

/** @author Aleksandr Klimenkov <alx.devel@gmail.com> */
class Week extends NumberFromStrfTime
{
    /**
     * Currently not in use
     *
     * @var int
     */
    public $mode;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        if ($parser->getLexer()->lookahead->type === Lexer::T_COMMA) {
            $parser->match(Lexer::T_COMMA);
            $this->mode = $parser->Literal();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    protected function getFormat(): string
    {
        return '%W';
    }
}
