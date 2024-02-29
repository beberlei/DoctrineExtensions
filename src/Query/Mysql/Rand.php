<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\SimpleArithmeticExpression;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Rand extends FunctionNode
{
    /** @var SimpleArithmeticExpression */
    private $expression = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        if ($this->expression) {
            return 'RAND(' . $this->expression->dispatch($sqlWalker) . ')';
        }

        return 'RAND()';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        if ($lexer->lookahead->type !== TokenType::T_CLOSE_PARENTHESIS) {
            $this->expression = $parser->SimpleArithmeticExpression();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
