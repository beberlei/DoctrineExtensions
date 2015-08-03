<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

class Round extends FunctionNode
{
    private $firstExpression = null;
    private $secondExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstExpression = $parser->SimpleArithmeticExpression();

        // parse second parameter if available
        if(Lexer::T_COMMA === $lexer->lookahead['type']){
            $parser->match(Lexer::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        // use second parameter if parsed
        if (null !== $this->secondExpression){
            return 'ROUND('
                . $this->firstExpression->dispatch($sqlWalker)
                . ', '
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'ROUND(' . $this->firstExpression->dispatch($sqlWalker) . ')';
    }
}
