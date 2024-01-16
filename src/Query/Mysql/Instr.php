<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

class Instr extends FunctionNode
{
    public $originalString = null;

    public $subString = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->originalString = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->subString = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'INSTR(%s, %s)',
            $this->originalString->dispatch($sqlWalker),
            $this->subString->dispatch($sqlWalker)
        );
    }
}
