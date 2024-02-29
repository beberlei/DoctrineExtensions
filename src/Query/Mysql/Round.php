<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Round extends FunctionNode
{
    private $firstExpression = null;

    private $secondExpression = null;

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->firstExpression = $parser->SimpleArithmeticExpression();

        // parse second parameter if available
        if ($lexer->lookahead->type === TokenType::T_COMMA) {
            $parser->match(TokenType::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        // use second parameter if parsed
        if ($this->secondExpression !== null) {
            return 'ROUND('
                . $this->firstExpression->dispatch($sqlWalker)
                . ', '
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'ROUND(' . $this->firstExpression->dispatch($sqlWalker) . ')';
    }
}
