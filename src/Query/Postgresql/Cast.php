<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Cast extends FunctionNode
{
    public $subject;

    public $type;

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'CAST(%s AS %s)',
            $this->subject->dispatch($sqlWalker),
            $this->type
        );
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->subject = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_AS);
        $parser->match(Lexer::T_IDENTIFIER);

        $lexer = $parser->getLexer();
        $this->type = $lexer->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
