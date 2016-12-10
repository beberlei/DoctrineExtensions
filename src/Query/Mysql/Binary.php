<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
class Binary extends FunctionNode
{
    /** @var Node */
    private $stringPrimary;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'BINARY('
            . (
                $this->stringPrimary instanceof Node
                    ? $this->stringPrimary->dispatch($sqlWalker)
                    : "'" . $this->stringPrimary . "'"
            )
            . ')';
    }
}
