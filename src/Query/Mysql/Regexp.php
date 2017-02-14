<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Version;

class Regexp extends FunctionNode
{
    /** @var Node */
    public $value = null;
    /** @var Node */
    public $regexp = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->value = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->regexp = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        if (Version::VERSION < 2.3) {
            $sqlLeft = "'" . $this->value . "'";
            $sqlRight = "'" . $this->regexp . "'";
        } else {
            $sqlLeft =  $this->value->dispatch($sqlWalker);
            $sqlRight =  $this->regexp->dispatch($sqlWalker);
        }
        return '(' . $sqlLeft . ' REGEXP ' . $sqlRight . ')';
    }
}
