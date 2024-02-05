<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 * @author Sarjono Mukti Aji <me@simukti.net>
 * @author Łukasz Nowicki <lukasz.mnowicki@gmail.com>
 */
class Week extends FunctionNode
{
    public $date;

    public $mode;

    public function getSql(SqlWalker $sqlWalker): string
    {
        $sql = 'WEEK(' . $sqlWalker->walkArithmeticPrimary($this->date);
        if ($this->mode !== null) {
            $sql .= ', ' . $sqlWalker->walkLiteral($this->mode);
        }

        $sql .= ')';

        return $sql;
    }

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
}
