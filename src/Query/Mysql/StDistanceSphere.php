<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class StDistanceSphere extends FunctionNode
{
    public $origin;

    public $remote;

    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'ST_DISTANCE_SPHERE(%s, %s)',
            $this->origin->dispatch($sqlWalker),
            $this->remote->dispatch($sqlWalker)
        );
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->origin = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->remote = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
