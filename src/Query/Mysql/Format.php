<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\QueryException;

/**
 * @author Marek Karmelski <marek.karmelski@gmail.com>
 */
class Format extends FunctionNode
{
    public $numberExpression = null;

    public $patternExpression = null;

    public $optionalLocaleExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->numberExpression = $parser->SimpleArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->patternExpression = $parser->SimpleArithmeticExpression();

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->optionalLocaleExpression = $parser->StringExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'FORMAT(' .
            $this->numberExpression->dispatch($sqlWalker) . ', ' .
            $this->patternExpression->dispatch($sqlWalker) .
            (($this->optionalLocaleExpression) ? ', ' . $this->optionalLocaleExpression->dispatch($sqlWalker) : '') .
            ')';
    }
}