<?php

namespace DoctrineExtensions\Query\Mssql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Teresa Waldl <teresa@waldl.org>
 */
class FromUnixtime extends FunctionNode
{
    public $firstExpression = null;

    public $secondExpression = null;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        if (null !== $this->secondExpression) {
            return 'FORMAT(DATEADD(SECONDS, '
                . $this->firstExpression->dispatch($sqlWalker)
                . ', \'1970-01-01\'), '
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'DATEADD(SECONDS, ' . $this->firstExpression->dispatch($sqlWalker) . ', \'1970-01-01\')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstExpression = $parser->ArithmeticPrimary();

        // parse second parameter if available
        if (Lexer::T_COMMA === $lexer->lookahead['type']) {
            $parser->match(Lexer::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
