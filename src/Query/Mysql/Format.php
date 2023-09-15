<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Wally Noveno <wally.noveno@gmail.com>
 */
class Format extends FunctionNode
{
    public $numberExpression = null;

    public $patternExpression = null;

    public $localeExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->numberExpression = $parser->SimpleArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->patternExpression = $parser->SimpleArithmeticExpression();

        if (!$parser->getLexer()->isNextToken(Lexer::T_CLOSE_PARENTHESIS)) {
            $parser->match(Lexer::T_COMMA);
            $this->localeExpression = $parser->SimpleArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return sprintf(
            'FORMAT(%s, %s, %s)',
            $this->numberExpression->dispatch($sqlWalker),
            $this->patternExpression->dispatch($sqlWalker),
            $this->localeExpression !== null ? $this->localeExpression->dispatch($sqlWalker) : 'NULL'
        );
    }
}
