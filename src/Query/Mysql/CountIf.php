<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

use function sprintf;
use function strtolower;

class CountIf extends FunctionNode
{
    private $expr1;

    private $expr2;

    private $inverse = false;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();

        $lexer = $parser->getLexer();

        while ($lexer->lookahead->type === Lexer::T_IDENTIFIER) {
            switch (strtolower($lexer->lookahead->value)) {
                case 'inverse':
                    $parser->match(Lexer::T_IDENTIFIER);
                    $this->inverse = true;

                break;
                default: // Identifier not recognized (causes exception).
                    $parser->match(Lexer::T_CLOSE_PARENTHESIS);

                break;
            }
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'COUNT(CASE %s WHEN %s THEN %s END)',
            $sqlWalker->walkArithmeticPrimary($this->expr1),
            $sqlWalker->walkArithmeticPrimary($this->expr2),
            !$this->inverse ? '1 ELSE NULL' : 'NULL ELSE 1'
        );
    }
}
