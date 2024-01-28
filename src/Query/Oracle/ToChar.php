<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

use function sprintf;

class ToChar extends FunctionNode
{
    private $datetime;

    private $fmt;

    private $nls = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        if ($this->nls) {
            return sprintf(
                'TO_CHAR(%s, %s, %s)',
                $sqlWalker->walkArithmeticPrimary($this->datetime),
                $sqlWalker->walkArithmeticPrimary($this->fmt),
                $sqlWalker->walkArithmeticPrimary($this->nls)
            );
        }

        return sprintf(
            'TO_CHAR(%s, %s)',
            $sqlWalker->walkArithmeticPrimary($this->datetime),
            $sqlWalker->walkArithmeticPrimary($this->fmt)
        );
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->datetime = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->fmt = $parser->StringExpression();

        if ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->nls = $parser->StringExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
