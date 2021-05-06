<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Subselect;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class RegexpReplace extends FunctionNode
{
    /**
     * @var Subselect
     */
    private $value;

    /**
     * @var Subselect
     */
    private $regexp;

    /**
     * @var Subselect
     */
    private $replace;

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'REGEXP_REPLACE('.
            $this->value->dispatch($sqlWalker).', '.
            $this->regexp->dispatch($sqlWalker).', '.
            $this->replace->dispatch($sqlWalker).
            ')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->value = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);
        $this->regexp = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->replace = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
