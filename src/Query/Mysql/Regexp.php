<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;

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
        return '('
            . (
                is_a( $this->value, 'Doctrine\ORM\Query\AST\Node')
                    ? $this->value->dispatch($sqlWalker)
                    : "'" . $this->value . "'"
            )
            . ' REGEXP '
            . (
                is_a( $this->regexp, 'Doctrine\ORM\Query\AST\Node')
                    ? $this->regexp->dispatch($sqlWalker)
                    : "'" . $this->regexp . "'"
            )
            . ')';
    }
}
