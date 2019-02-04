<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\Lexer;

/**
 * @author Aleksandr Klimenkov <alx.devel@gmail.com>
 */
class Week extends AbstractStrfTime
{
    /**
     * Currently not in use
     * @var int
     */
    public $mode;

    public function parse(\Doctrine\ORM\Query\Parser $parser): void
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
