<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Version;

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
        if (Version::VERSION < 2.3) {
            $sql = "'" . $this->stringPrimary . "'";
        } else {
            $sql =  $this->stringPrimary->dispatch($sqlWalker);
        }
        return 'BINARY(' . $sql . ')';
    }
}
