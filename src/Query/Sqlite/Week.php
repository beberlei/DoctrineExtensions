<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\Lexer;

/**
 * @author Aleksandr Klimenkov <alx.devel@gmail.com>
 */
class Week extends NumberFromStrfTime
{
    /**
     * Currently not in use
     * @var int
     */
    public $mode;

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

    protected function getFormat()
    {
        return '%W';
    }
}
